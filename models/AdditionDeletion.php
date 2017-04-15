<?php

use Illuminate\Database\Eloquent\Model;

class AdditionDeletion extends Model
{
    protected $table = 'additionsDeletions';
	
	public $userId;
	public $collectionId;
	public $itemId;
	public $deleted;
	
}
