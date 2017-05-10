<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('getCollections/{userId}', 'CollectionController@getCollectionsForUser');

Route::get('findCollections/{searchTerm}', 'CollectionController@findCollections');

Route::get('addCollection/{collectionId}/{userId}', 'CollectionController@addCollection');

Route::get('getItemsForCollection/{collectionId}', 'ItemController@getItemsForCollection');

Route::get('getItemsForSingleUserCollection/{collectionId}/{userId}', 'ItemController@getItemsForSingleUserCollection');

Route::get('checkLogin/{email}/{password}', 'UserController@checkLogin');

Route::get('registerUser/{name}/{email}/{password}', 'UserController@registerUser');

Route::get('createCollection/{collectionName}/{usedId}/{buttonOneText}', 'CollectionController@createCollection');

Route::get('createCollection/{collectionName}/{usedId}/{buttonOneText}/{buttonTwoText}', 'CollectionController@createCollection');

Route::get('createCollection/{collectionName}/{usedId}/{buttonOneText}/{buttonTwoText}/{buttonTwoText}', 'CollectionController@createCollection');

Route::get('addItemToCollection/{itemName}/{collectionId}/{userId}', 'ItemController@addItemToCollection');

Route::get('addItemToCollectionForUser/{itemName}/{collectionId}/{userId}', 'ItemController@addItemToCollectionForUser');
