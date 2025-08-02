<?php
    
namespace App\Services;

use App\Exceptions\UnAuthorizedException;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;



class AdminAuthService extends BaseService {


    public function __construct()
    {
        $this->model = Admin::class;
        
    }

    public static function Login($req)
    {
        $user = Admin::where('email', $req->email)->first();
        if ($user && Hash::check($req->password, $user->password)) {
          
            $user->access_token = $user->createToken('API')->plainTextToken;
            return $user;
        }else {
            throw new UnAuthorizedException();
        }
        return false;
    }

}