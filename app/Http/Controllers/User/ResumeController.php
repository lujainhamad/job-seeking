<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseCRUDController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Resume\CreateResumeRequest;
use App\Http\Requests\Resume\UpdateResumeRequest;
use App\Http\Resources\Resume\ResumeResource;
use App\Models\Resume;
use App\Models\User;
use App\Services\ResumeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class ResumeController extends BaseCRUDController
{
    public function __construct(ResumeService $service)
    {
        $this->service = $service;
        $this->createRequest = CreateResumeRequest::class;
        $this->updateRequest = UpdateResumeRequest::class;
        $this->resource = ResumeResource::class;
    }

    public function show($model)
    {
        $user = Auth::user();
        $model = Resume::where('user_id', $user->id)->first();
        dd("fgre");
        $res = $this->showResource($this->service->getOne($model));
        return Response::success($res);
    }
    
    public function myCv()
    {
        $user = Auth::user();
        $model = Resume::where('user_id', $user->id)->orderBy('created_at','desc')->first();
        if ($model) {
            $res = new ResumeResource($this->service->getOne($model));
        } else {
            $res = $model;
        }
        return Response::success($res);
    }

    public function viewHtml($id)
    {
        $user = User::findOrFail($id);
        $resume = Resume::with(['experiences', 'educations', 'skills', 'languages'])
            ->where('user_id', $user->id)
            ->first();

        return view('resume', compact('resume', 'user'));
    }

    public function downloadPdf($id)
    {
        $user = User::findOrFail($id);
        $resume = Resume::with(['experiences', 'educations', 'skills', 'languages'])
            ->where('user_id', $user->id)
            ->first();

        if (!$resume) {
            return response()->json(['error' => 'No resume found'], 404);
        }

        $pdf = PDF::loadView('resume', compact('resume', 'user'));
        
        $filename = $user->name . '_Resume_' . date('Y-m-d') . '.pdf';
        
        return $pdf->stream($filename,);
    }
}
