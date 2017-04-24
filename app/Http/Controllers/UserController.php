<?php

namespace App\Http\Controllers;

use App\Models\User as User;

class UserController extends Controller
{
    //Checks user login
    public function checkLogin($aUserEmail, $aUserPassword)
    {
        $lUser = User::getUserByEmail($aUserEmail);

        if($lUser->password === $aUserPassword)
        {
            return $lUser->toJson();
        }

        return "";
    }
}
