<?php

namespace App\Http\Controllers;

use App\Models\Collection as Collection;

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

        DB::table('usersCollections as uc')
            ->firstOrCreate(
            [
                'userId' => $aUserId,
                'collectionId' => $aCollectionId
            ]);

        $lItems = Collection::join('collectionsItems as ci', 'collections.id', '=', 'ci.collectionId')
            ->join('usersItems as ui', 'items.id', '=', 'ui.itemId');
            ->where('ci.collectionId', '=', $aCollectionId);

        foreach($lItems as $iItem)
        {
            DB::table('usersItems as ui')
                ->firstOrCreate(
                [
                    'userId' => $aUserId,
                    'itemId' => $iItem->itemId,
                    'buttonOneChecked' => false,
                    'buttonTwoChecked' => false,
                    'buttonThreeChecked' => false,
                    'deleted' => false
                ]);
        }
        
        DB::commit();

        return "Collection Added!";
    }
}
