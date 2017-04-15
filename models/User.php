<?php

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
	
	public $userId;
	public $name;
	
	public static function getUser($aUserId)
	{
		return User::where('userId', '=', $aUserId)
			->get();
	}
}
