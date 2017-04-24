<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    
    protected $id;
    protected $name;
    protected $password;
    
    protected $visible = ['id', 'email', 'name'];
    protected $appends = ['is_valid'];

    public static function getUser($aUserId)
    {
        return User::where('userId', '=', $aUserId)
            ->get();
    }

    public static function getUserByEmail($aUserEmail)
    {
        return User::where('email', '=', $aUserEmail)
            ->get();
    }

    public static function getIsValidAttribute()
    {
        return true;
    }
}
