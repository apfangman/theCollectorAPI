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

    public static function getItemsForUserInCollection($aCollectionId, $aUserId)
    {
        return Item::join('usersItems as ui', 'items.id', '=', 'ui.itemId')
            ->join('collections as c', 'items.collectionId', '=', 'c.id')
			->where('ui.deleted', '=', false)
            ->where('ui.userId', '=', $aUserId)
            ->where('items.collectionId', '=', $aCollectionId)
            ->select('items.id', 
                'items.name', 
                'items.picture', 
                'ui.userId', 
                'items.collectionId', 
                'c.buttonOne', 
                'c.buttonTwo', 
                'c.buttonThree', 
                'ui.buttonOneChecked', 
                'ui.buttonTwoChecked', 
                'ui.buttonThreeChecked')
            ->get();
    }
    
    public static function getItemsInCollection($aCollectionId)
    {
        return Item::join('collections as c', 'items.collectionId', '=', 'c.id')
            ->where('items.collectionId', '=', $aCollectionId)
            ->where('items.userAdded', '=', false)
            ->select('items.id', 
                'items.name', 
                'items.picture', 
                'items.storeLink',
                'items.collectionId', 
                'c.buttonOne', 
                'c.buttonTwo', 
                'c.buttonThree')
            ->get();
    }
}
