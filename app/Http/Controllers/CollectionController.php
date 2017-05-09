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

        $lItems = Collection::join('collectionsItems as ci', 'collections.id', '=', 'ci.collectionId')
            ->where('ci.collectionId', '=', $aCollectionId)
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
}
