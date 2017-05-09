<?php

namespace App\Http\Controllers;

use App\Models\User as User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    //Checks user login
    public function checkLogin($aUserEmail, $aUserPassword)
    {
        if(Auth::attempt(['email' => $aUserEmail, 'password' => $aUserPassword]))
        {
            return User::getUserByEmail($aUserEmail)->toJson();
        }

        return "";
    }

    //Registers user
    public function registerUser($aName, $aEmail, $aPassword)
    {
        $lUser = User::where('email', '=', $aEmail)->get();
        if($lUser != null)
        {
            $lValidInsert = User::createUser($aName, $aEmail, $aPassword);
            $lUser = User::where('email', '=', $aEmail)
                ->select('id', 'name')
                ->get();
            if($lValidInsert)
            {
                return $lUser;
            }
        }
        return;
    }
}
