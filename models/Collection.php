<?php

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $table = 'collections';
	
	public $collectionId;	
	public $name;
	public $picture;
	
	public static function getCollection($aCollectionId)
	{
		return Collection::where('collectionId', '=', $aCollectionId)
			->get();
	}
	
	public static function getCollectionsForUser($aUserId)
	{
		return Collection::join('usersCollections as uc', 'collections.collectionId', '=', 'uc.collectionId')
			->where('uc.userId', '=', $aUserId)
			->get();
	}
}
