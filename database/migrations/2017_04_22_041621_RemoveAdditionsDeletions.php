<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveAdditionsDeletions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::beginTransaction();

	Schema::drop('additionsDeletions');

	Schema::table('usersItems', function(Blueprint $table)
	{
	    $table->boolean('deleted');
	});

	Schema::table('items', function(Blueprint $table)
	{
	    $table->boolean('userAdded');
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
        Schema::create('additionsDeletions', function (Blueprint $table) {
            $table->integer('userId');
            $table->integer('itemId');
            $table->integer('collectionId');
            $table->boolean('deleted');
            
            $table->foreign('userId')->references('id')->on('users');
            $table->foreign('itemId')->references('id')->on('items');
            $table->foreign('collectionId')->references('id')->on('collections');
        });

	Schema::table('usersItems', function(Blueprint $table)
	{
	    $table->dropColumn('deleted');
	});

	Schema::table('items', function(Blueprint $table)
	{
	    $table->dropColumn('userAdded');
	});
    }
}
