<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInitialTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::beginTransaction();
        
        Schema::create('collections', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name');
            $table->text('picture');
        });
        
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name');
            $table->text('picture');
            $table->text('storeLink');
            $table->text('buttonOne');
            $table->text('buttonTwo');
            $table->text('buttonThree');
        });
        
        Schema::create('usersItems', function (Blueprint $table) {
            $table->integer('userId');
            $table->integer('itemId');
            $table->boolean('buttonOneChecked');
            $table->boolean('buttonTwoChecked');
            $table->boolean('buttonThreeChecked');
            
            $table->foreign('userId')->references('id')->on('users');
            $table->foreign('itemId')->references('id')->on('items');
        });
        
        Schema::create('collectionsItems', function (Blueprint $table) {
            $table->integer('collectionId');
            $table->integer('itemId');
            
            $table->foreign('collectionId')->references('id')->on('collections');
            $table->foreign('itemId')->references('id')->on('items');
        });
        
        Schema::create('usersCollections', function (Blueprint $table) {
            $table->integer('userId');
            $table->integer('collectionId');
            
            $table->foreign('userId')->references('id')->on('users');
            $table->foreign('collectionId')->references('id')->on('collections');
        });
        
        Schema::create('additionsDeletions', function (Blueprint $table) {
            $table->integer('userId');
            $table->integer('itemId');
            $table->integer('collectionId');
            $table->boolean('deleted');
            
            $table->foreign('userId')->references('id')->on('users');
            $table->foreign('itemId')->references('id')->on('items');
            $table->foreign('collectionId')->references('id')->on('collections');
        });
        
        DB::commit();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('additionsDeletions');
        Schema::drop('usersCollections');
        Schema::drop('collectionsItems');
        Schema::drop('usersItems');
        Schema::drop('items');
        Schema::drop('collections');
    }
}
