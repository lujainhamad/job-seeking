<?php
    
namespace App\Services;

use App\Models\Education;


class EducationService extends BaseService {


    public function __construct()
    {
        $this->model = Education::class;
        
    }

}