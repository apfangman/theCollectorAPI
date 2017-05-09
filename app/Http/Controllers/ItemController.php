<?php

namespace App\Http\Controllers;

use App\Models\Item as Item;

class ItemController extends Controller
{
    public function getItemsForCollection($aCollectionId)
    {
        return Item::getItemsInCollection($aCollectionId)->toJson();
    }

    //Gets all the collections for a particular user
    public function getItemsForSingleUserCollection($aCollection, $aUserId)
    {
        return Item::getItemsForUserInCollection($aCollectionId, $aUserId)->toJson();
    }
}
