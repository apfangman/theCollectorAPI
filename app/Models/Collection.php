<?php

namespace App\Models;

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
        return Collection::join('usersCollections as uc', 'collections.id', '=', 'uc.collectionId')
            ->where('uc.userId', '=', $aUserId)
            ->get();
    }

    public static function findCollections($aSearchTerm)
    {
        return Collection::where('name', 'LIKE', $aSearchTerm)
            ->get();
    }

    public static function createCollection($aCollectionName, $aButtonOneText, $aButtonTwoText = "", $aButtonThreeText = "")
    {
        return Collection::insert(
        [
            'name' => $aUserName,
            'buttonOne' => $aButtonOneText,
            'buttonTwo' => $aButtonTwoText,
            'buttonThree' => $aButtonThreeText
        ]);
    }
}
