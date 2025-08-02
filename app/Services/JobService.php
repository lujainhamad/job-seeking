<?php

namespace App\Services;

use App\Exceptions\CustomExceptionWithMessage;
use App\Helpers\Transaction;
use App\Models\Job;
use App\Http\Pipelines\Job\JobPipeline;
use App\Http\Resources\InterviewResource;
use App\Jobs\SendNotification;
use App\Models\Interview;
use App\Models\User;
use App\Services\Notifications\FcmNotificationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class JobService extends BaseService
{


    public function __construct()
    {
        $this->model = Job::class;
        $this->pipeline = JobPipeline::class;
        $this->manyToManyRelationsWithPivot = ['skills', 'languages'];
        $this->relations = ['skills', 'languages', 'education', 'jobOfferDates','company'];
    }

    public function getAll()
    {
        $query = $this->model::query();
        $query = $this->pipeline ? $this->pipeline::make(builder: $query) : $query;
        if (auth('company')->check()) {
            $query->where('company_id', auth()->id())
                ->orderByDesc('id');
        }
        return $query;
    }

    public function create($data)
    {
        return Transaction::run(function () use ($data) {
            foreach ($data as $key => $value) {
                try {
                    if (file_exists($value)) {
                        $data[$key] = StorageService::storeFile($value, $this->storagePath);
                    }
                } catch (Throwable $e) {
                }
            }
            $object = $this->model::create($data);
            if (isset($data['attachments'])) {
                foreach ($data['attachments'] as $attachment) {
                    $path = StorageService::storeFile($attachment, $this->storagePath);
                    $object->attachments()->create([
                        'user_id' => $data['user_id'] ?? $data['user']['id'],
                        'file' => $path,
                        'type' => StorageService::getType($attachment),
                    ]);
                }
            }
            $this->manyToManyRelationsWithPivot = ['skills'];
            $foreignKeys = ['skill_id'];
            $this->handleManyToManyRelationsWithPivotValues($object, $data, [], $foreignKeys);
            $this->manyToManyRelationsWithPivot = ['languages'];
            $foreignKeys = ['language_id'];
            $this->handleManyToManyRelationsWithPivotValues($object, $data, [], $foreignKeys);
            $this->handleManyToManyRelations($object, $data);
            $object->load($this->relations);

            return $object;
        });
    }

    public function createInterview($data)
    {
        DB::table('job_offers_users')
            ->where('job_offer_id', $data['job_offer_id'])
            ->where('user_id', $data['user_id'])
            ->update(['interview_date' => $data['interview_date']]);

        return true;
    }
    public function createInitialSalary($data)
    {
        DB::table('job_offers_users')
            ->where('job_offer_id', $data['job_offer_id'])
            ->where('user_id', $data['user_id'])
            ->update(['initial_salary' => $data['initial_salary']]);

        return true;
    }

    public function apply($id, $date)
    {
        $user = auth()->user();
        
        
        if ($user->jobOffers()->where('job_offer_id', $id)->whereIn('interview_status', ['pending', 'approved'])->exists()) {
            throw new CustomExceptionWithMessage('You have already applied for this job');
        }

        $user->jobOffers()->attach($id, ['interview_date' => $date['interview_date']]);

        return true;
    }

    public function myJobs()
    {
        $user = Auth::user();

        return $user->jobOffers;
    }

    public function chooseDate($data, $id)
    {
        $user = auth()->user();
        DB::table('job_offers_users')
            ->where('job_offer_id', $id)
            ->where('user_id', $user->id)
            ->update(['interview_date' => $data['date']]);
        return true;
    }

    public function submitInterview($id)
    {
        $Interview = Interview::find($id);
        $Interview->update(['interview_status' => 'approved']);

        $msg = 'Dear user your appointment has been approved';
        $title = 'Job offer updates';
        $user = User::find($Interview->user_id);
        $fcmService = new FcmNotificationService($user, $title, $msg);
        SendNotification::dispatch($fcmService);

        return true;
    }
    public function rejectInterview($id)
    {
        $Interview = Interview::find($id);
        $Interview->update(['interview_status' => 'rejected']);

        $msg = 'Dear user your appointment has been rejected';
        $title = 'Job offer updates';
        $user = User::find($Interview->user_id);
        $fcmService = new FcmNotificationService($user, $title, $msg);
        SendNotification::dispatch($fcmService);

        return true;
    }

    public function acceptUser($id)
    {
        $Interview = Interview::find($id);
        $Interview->update(['is_approved' => 1]);

        $msg = 'Dear user you are has been approved in our company';
        $title = 'Job offer updates';
        $user = User::find($Interview->user_id);
        $fcmService = new FcmNotificationService($user, $title, $msg);
        SendNotification::dispatch($fcmService);

        return true;
    }

    public function interviews()
    {
        $companyId = auth()->user()->id;
        $query = Interview::whereHas('jobOffer', function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })->with(['user', 'jobOffer']);
        if(request()->has('job_offer_id')){
            $query->where('job_offer_id',request()->get('job_offer_id'));
        }
        $interviews = $query->get();
        return InterviewResource::collection($interviews);
    }
    public function userInterviews()
    {
        $userId = auth()->user()->id;

        $interviews = Interview::where('user_id', $userId)->with(['user', 'jobOffer'])->get();
        return $interviews;
    }

    public function mostPublished()
    {
        $offers = DB::table('jobs_offers as a')
            ->select('a.*')
            ->selectSub(function ($query) {
                $query->from('jobs_offers as b')
                    ->selectRaw('COUNT(*)')
                    ->whereRaw('b.job_title LIKE CONCAT("%", a.job_title, "%")')
                    ->whereRaw('b.id != a.id');
            }, 'job_title_match_count')
            ->selectSub(function ($query) {
                $query->from('jobs_offers as b')
                    ->select('b.job_title')
                    ->whereRaw('b.job_title LIKE CONCAT("%", a.job_title, "%")')
                    ->whereRaw('b.id != a.id')
                    ->limit(1);
            }, 'similar_job_title_example')
            ->orderByDesc('job_title_match_count')
            ->get();

        return $offers;
    }
}
