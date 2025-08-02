<?php

namespace App\Services;

use App\Helpers\Transaction;
use App\Models\Resume;
use App\Http\Pipelines\Resume\ResumePipeline;
use App\Models\Experience;
use Illuminate\Support\Facades\Auth;
use Throwable;

class ResumeService extends BaseService
{


    public function __construct()
    {
        $this->model = Resume::class;
        $this->pipeline = ResumePipeline::class;
        $this->relations = ['educations','skills','languages'];
        $this->manyToManyRelationsWithPivot = ['educations','skills','languages'];
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
            if (isset($data['experiences'])) {
                // $data['experiences']['resume_id'] = $object->id;
                foreach ($data['experiences'] as $key => $value) {
                    $value['resume_id'] = $object->id; // ['resume_id' ]
                    $value['user_id'] = Auth::id();
                    Experience::create($value);
                }
            }

            if (isset($data['educations'])) {

                $foreignKeys = ['education_id'];
                $this->handleManyToManyRelationsWithPivotValues($object, ['educations' => $data['educations']], [], $foreignKeys);
                
            }
            if (isset($data['skills'])) {
                
                $foreignKeys = ['skill_id'];
                $this->handleManyToManyRelationsWithPivotValues($object, ['skills' => $data['skills']], [], $foreignKeys);
            }
            if (isset($data['languages'])) {
                
                $foreignKeys = ['language_id'];
                $this->handleManyToManyRelationsWithPivotValues($object, ['languages' => $data['languages']], [], $foreignKeys);
            }

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
            $this->handleManyToManyRelations($object, $data);
            $object->load($this->relations);

            return $object;
        });
    }
}
