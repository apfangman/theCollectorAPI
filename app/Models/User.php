<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class User extends Model
{
    protected $table = 'users';
    
    protected $id;
    protected $name;
    protected $password;
    
    protected $visible = ['id', 'email', 'name'];

    public static function getUser($aUserId)
    {
        return User::where('userId', '=', $aUserId)
            ->first();
    }

    public static function getUserByEmail($aUserEmail)
    {
        return User::where('email', '=', $aUserEmail)
            ->first();
    }

    public static function createUser($aUserName, $aUserEmail, $aUserPassword)
    {
        try
        {
            $aUserPassword = Hash::make($aUserPassword);
            return User::insert(
            [
                'name' => $aUserName,
                'email' => $aUserEmail,
                'password' => $aUserPassword
            ]);
        }
        catch(\Illuminate\Database\QueryException $e)
        {
            return false;
        }
    }
}
