<?php
    
namespace App\Services;

use App\Exceptions\ForbiddenUserException;
use App\Exceptions\UnAuthorizedException;
use App\Helpers\Transaction;
use App\Http\Resources\Company\CompanyResource;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Throwable;

class CompanyAuthService {
    
    public function register($req){
        return Transaction::run(function () use ($req) {
            foreach($req as $key => $value){
                try{
                    if(file_exists($value)){
                        $req[$key] = StorageService::storeFile($value,'images/company/');
                    }
                }catch(Throwable $e){}
            }
            $comapny = Company::create($req);
            return new CompanyResource($comapny);
        });
    }

    public static function Login($req)
    {
        $user = Company::where('email', $req->email)->first();
        if (!$user->is_active) {
            throw new ForbiddenUserException();
        }
        if ($user && Hash::check($req->password, $user->password)) {
          
            $user->access_token = $user->createToken('API')->plainTextToken;
            return $user;
        }else {
            throw new UnAuthorizedException();
        }
        return false;
    }

    public function updateProfile($req){
        return Transaction::run(function () use ($req) {
            foreach($req as $key => $value){
                try{
                    if(file_exists($value)){
                        $req[$key] = StorageService::storeFile($value,'images/user/');
                    }
                }catch(Throwable $e){}
            }
            $user = auth()->user();
            $user->update($req);
            
            return new CompanyResource($user);
        });
    }

    public function getProfile(){
        $company = auth()->user();
        return new CompanyResource($company);
    }

}