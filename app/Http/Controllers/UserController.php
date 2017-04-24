<?php

namespace App\Http\Controllers;

use App\Models\User as User;

class UserController extends Controller
{
    //Gets all the collections for a particular user
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
