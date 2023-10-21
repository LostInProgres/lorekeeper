<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUnlockableTraitTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unlocked_features', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('character_id')->unsigned(); 
            $table->integer('feature_id')->unsigned(); 

            $table->unique(['character_id', 'feature_id']);
        });

        Schema::table('features', function (Blueprint $table) {
            $table->boolean('is_default')->default(0); //can be selected for free at any time
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
