<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseCRUDController;
use App\Http\Controllers\BaseIndexController;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProblemReportRequest;
use App\Http\Requests\RespondProblemReport;
use App\Http\Resources\ProblemReport\ProblemReportResource;
use App\Models\ProblemReport;
use App\Services\ProblemReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ProblemReportController extends BaseCRUDController
{
    public function __construct(ProblemReportService $service)
    {
        $this->service = $service; 
        $this->resource = ProblemReportResource::class;
        $this->createRequest = CreateProblemReportRequest::class;
    }

    public function responed(RespondProblemReport $request,ProblemReport $problem_report)
    {
        $data = $request->validated();
        $res = $this->service->responed($data,$problem_report);
        return Response::success($res);
    }   
}
