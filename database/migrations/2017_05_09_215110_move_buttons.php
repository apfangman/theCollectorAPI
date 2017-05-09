<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MoveButtons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::beginTransaction();

        Schema::table('items', function (Blueprint $table) 
        {
            $table->dropColumn('buttonOne');
            $table->dropColumn('buttonTwo');
            $table->dropColumn('buttonThree');

            $table->integer('collectionId');
            $table->foreign('collectionId')->references('id')->on('collections');
        });

        Schema::table('collections', function (Blueprint $table)
        {
            $table->text('buttonOne');
            $table->text('buttonTwo');
            $table->text('buttonThree');

            $table->dropColumn('picture');
        });

        Schema::drop('collectionsItems');

        DB::commit();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::beginTransaction();

        Schema::table('collections', function (Blueprint $table) 
        {
            $table->dropColumn('buttonOne');
            $table->dropColumn('buttonTwo');
            $table->dropColumn('buttonThree');

            $table->text('picture');
        });

        Schema::table('items', function (Blueprint $table)
        {
            $table->text('buttonOne');
            $table->text('buttonTwo');
            $table->text('buttonThree');

            $table->dropColumn('collectionId');
        });

        Schema::create('collectionsItems', function (Blueprint $table) {
            $table->integer('collectionId');
            $table->integer('itemId');
            
            $table->foreign('collectionId')->references('id')->on('collections');
            $table->foreign('itemId')->references('id')->on('items');
        });

        DB::commit();
    }
}

