<?php
    
namespace App\Services;

use App\Http\Resources\ProblemReport\ProblemReportResource;
use App\Models\ProblemReport;


class ProblemReportService extends BaseService {


    public function __construct()
    {
        $this->model = ProblemReport::class;
        $this->relations = ['user','jobOffer'];
    }

    public function responed($data,$problem_report){
        $problem_report->response = $data['response'];
        $problem_report->save();
        return new ProblemReportResource($problem_report);
    }

}