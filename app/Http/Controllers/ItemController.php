<?php

namespace App\Http\Controllers;

use App\Models\Collection as Collection;

class ItemController extends Controller
{
    public function getItemsForCollection($aCollectionId)
    {
        return Item::getItemsInCollection($aCollectionId)->toJson();
    }

    //Gets all the collections for a particular user
    public function getItemsForSingleUserCollection($aUserId, $aCollectionId)
    {
        return Item::getItemsForUserInCollection($aUserId, $aCollectionId)->toJson();
    }
}
