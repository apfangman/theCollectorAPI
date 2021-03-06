<?php

namespace App\Http\Controllers;

use App\Models\Collection as Collection;
use Illuminate\Support\Facades\DB;

class CollectionController extends Controller
{
    //Gets all the collections for a particular user
    public function getCollectionsForUser($aUserId)
    {
        return Collection::getCollectionsForUser($aUserId)->toJson();
    }

    public function findCollections($aSearchTerm)
    {
        //find any collection that has the search term anywhere
        //in the name of the collection
        $aSearchTerm = "%" . $aSearchTerm . "%";
        return Collection::findCollections($aSearchTerm)->toJson();
    }

    public function addCollection($aCollectionId, $aUserId)
    {
        DB::beginTransaction();

        $lCollection = DB::table('usersCollections as uc')
            ->where('userId', '=', $aUserId)
            ->where('collectionId', '=', $aCollectionId)
            ->first();

        if($lCollection == null)
        {
            DB::table('usersCollections as uc')
                ->insert(
                [
                    'userId' => $aUserId,
                    'collectionId' => $aCollectionId
                ]);
        }

        $lItems = Collection::join('items as i', 'collections.id', '=', 'i.collectionId')
            ->where('i.collectionId', '=', $aCollectionId)
            ->where('i.userAdded', '=', false)
            ->select('i.id as itemId')
            ->get();

        foreach($lItems as $iItem)
        {
            $lItem = DB::table('usersItems as uc')
                ->where('userId', '=', $aUserId)
                ->where('itemId', '=', $iItem->itemId)
                ->first();

            if($lItem == null)
            {
                DB::table('usersItems as ui')
                    ->insert(
                    [
                        'userId' => $aUserId,
                        'itemId' => $iItem->itemId,
                        'buttonOneChecked' => false,
                        'buttonTwoChecked' => false,
                        'buttonThreeChecked' => false,
                        'deleted' => false
                    ]);
            }            
        }
        
        DB::commit();

        return "Collection Added!";
    }

    public function createCollection($aCollectionName, $aUserId, $aButtonOneText, $aButtonTwoText = "", $aButtonThreeText = "")
    {
        DB::beginTransaction();

        Collection::createCollection($aCollectionName, $aButtonOneText, $aButtonTwoText, $aButtonThreeText);
        $lCreatedCollection = Collection::orderBy('id', 'desc')
            ->first();
            
        DB::table('usersCollections')
            ->insert(
                [
                    'userId' => $aUserId,
                    'collectionId' => $lCreatedCollection->id
                ]
            );

        DB::commit();
        return $lCreatedCollection;
    }
}
