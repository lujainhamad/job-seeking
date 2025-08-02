<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        
    }


    public function boot(): void
    {
        Response::macro('success',function($data,$code = 200){
            return response()->json([
                'success' => true,
                'data' => $data,
                'message' => __('custom.Success')
            ],$code);
        });

        Response::macro('error',function($message = 'Unexpected error' ,int $status_code = 400){
            return response()->json([
                'success' => false,
                'message' => __('custom.'.$message.'')
            ],$status_code);
        });
    }
}
