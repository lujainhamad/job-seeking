<?php
    
namespace App\Services;

use App\Models\Language;


class LanguageService extends BaseService {


    public function __construct()
    {
        $this->model = Language::class;
        
    }

}