<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';
    
    public $itemId;
    public $name;
    public $picture;
    public $storeLink;
    public $buttonOneText;
    public $buttonTwoText;
    public $buttonThreeText;
    
    public static function getItems($aItemId)
    {
        return Item::where('itemId', '=', $aItemId)
            ->get();
    }
    
    //Still need to add in additions and deletions
    public static function getItemsForUserInCollection($aUserId, $aCollectionId)
    {
        return Item::join('usersItems as ui', 'items.itemId', '=', 'ui.itemId')
            ->join('collectionsItems as ci', 'items.itemId', '=', 'ci.itemId')
            ->where('ui.userId', '=', $aUserId)
            ->where('ci.collectionId', '=', $aCollectionId)
            ->get();
    }
    
    public static function getItemsInCollection($aCollectionId)
    {
        return Item::join('collectionsItems as ci', 'items.itemId.', '=', 'ci.itemId')
            ->where('ci.collectionId', '=', $aCollectionId)
            ->get();
    }
}
