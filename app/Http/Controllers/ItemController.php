<?php

namespace App\Http\Controllers;

use App\Models\Item as Item;
use Illuminate\Support\Facades\DB;

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
        DB::beginTransaction();

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

        DB::commit();
    }

    public function addItemToCollectionForUser($aItemName, $aCollectionId, $aUserId)
    {
        DB::beginTransaction();

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

        DB::commit();
    }

    public function deleteItemFromCollectionForUser($aItemId, $aUserId)
    {
        DB::table('usersItems')
            ->where('userId', '=', $aUserId)
            ->where('itemId', '=', $aItemId)
            ->update(['deleted' => true]);

        return "Item Deleted!";
    }

    public function updateItem($aItemId, $aUserId, $aButtonChecked)
    {
        DB::beginTransaction();

        $lItem = DB::table('usersItems as ui')
            ->where('ui.userId', '=', $aUserId)
            ->where('ui.itemId', '=', $aItemId)
            ->first();

        if($aButtonChecked == "1")
        {
            $aButtonChecked = 'buttonOneChecked';
            $lFlag = $lItem->buttonOneChecked;
        }
        elseif($aButtonChecked == "2")
        {
            $aButtonChecked = 'buttonTwoChecked';
            $lFlag = $lItem->buttonTwoChecked;
        }
        else
        {
            $aButtonChecked = 'buttonThreeChecked';
            $lFlag = $lItem->buttonThreeChecked;
        }

        DB::table('usersItems as ui')
            ->where('itemId', '=', $aItemId)
            ->where('userId', '=', $aUserId)
            ->update([$aButtonChecked => !$lFlag]);

        DB::commit();

        return "Item Updated!";
    }
}
