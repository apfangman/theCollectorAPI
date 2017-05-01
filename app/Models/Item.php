<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';
    
    protected $itemId;
    protected $name;
    protected $picture;
    protected $storeLink;
    protected $buttonOneText;
    protected $buttonTwoText;
    protected $buttonThreeText;
    protected $deleted;

    //Still need to add in additions and deletions
    public static function getItemsForUserInCollection($aUserId, $aCollectionId)
    {
        return Item::join('collectionsItems as ci', 'items.id', '=', 'ci.itemId')
			->join('usersItems as ui', 'items.id', '=', 'ui.itemId')
			->where('ui.deleted', '=', false)
            ->where('ui.id', '=', $aUserId)
            ->where('ci.id', '=', $aCollectionId)
            ->select('items.id', 
                'items.name', 
                'items.picture', 
                'ui.userId', 
                'ci.collectionId', 
                'items.buttonOne', 
                'items.buttonTwo', 
                'items.buttonThree', 
                'ui.buttonOneChecked', 
                'ui.buttonTwoChecked', 
                'ui.buttonThreeChecked')
            ->get();
    }
    
    public static function getItemsInCollection($aCollectionId)
    {
        return Item::join('collectionsItems as ci', 'items.id.', '=', 'ci.id')
            ->where('ci.id', '=', $aCollectionId)
            ->where('items.userAdded', '=', false)
            ->get();
    }
}
