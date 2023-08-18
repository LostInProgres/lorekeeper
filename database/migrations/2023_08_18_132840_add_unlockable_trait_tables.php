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

        Schema::create('unlocked_features_log', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('feature_id')->unsigned();

            $table->integer('sender_id')->unsigned()->nullable();
            $table->integer('recipient_id')->unsigned()->nullable();
            $table->string('log'); 
            $table->string('log_type'); 
            $table->string('data', 1024)->nullable(); 

            $table->timestamps();

            $table->foreign('feature_id')->references('id')->on('features');

            $table->foreign('sender_id')->references('id')->on('users');
            $table->foreign('recipient_id')->references('id')->on('characters');
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
