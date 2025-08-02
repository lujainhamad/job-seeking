<?php
    
namespace App\Services;

use App\Models\Skill;


class SkillService extends BaseService {


    public function __construct()
    {
        $this->model = Skill::class;
        
    }

}