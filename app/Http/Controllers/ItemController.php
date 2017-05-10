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
    public function getItemsForSingleUserCollection($aCollectionId, $aUserId)
    {
        return Item::getItemsForUserInCollection($aCollectionId, $aUserId)->toJson();
    }

    public function addItemToCollection($aItemName, $aCollectionId, $aUserId)
    {
        Item::addItemToCollection($aItemName, $aCollectionId);

        $lItem = Item::orderBy('id', 'desc')
            ->first();

        DB::table('usersItems as ui')
            ->insert(
                [
                    'userId' => $aUserId,
                    'itemId' => $lItem->id,
                    'buttonOneChecked' => false,
                    'buttonTwoChecked' => false,
                    'buttonThreeChecked' => false,
                    'deleted' => false
                ]);
    }

    public function addItemToCollectionForUser($aItemName, $aCollectionId, $aUserId)
    {
        Item::addItemToCollectionForUser($aItemName, $aCollectionId);

        $lItem = Item::orderBy('id', 'desc')
            ->first();

        DB::table('usersItems as ui')
            ->insert(
                [
                    'userId' => $aUserId,
                    'itemId' => $lItem->id,
                    'buttonOneChecked' => false,
                    'buttonTwoChecked' => false,
                    'buttonThreeChecked' => false,
                    'deleted' => false
                ]);
    }
}
