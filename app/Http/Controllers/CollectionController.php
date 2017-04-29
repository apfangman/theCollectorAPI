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
        return Collection::findCollections($aSearchTerm)->toJson();
    }
}
