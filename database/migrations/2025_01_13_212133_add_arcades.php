<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddArcades extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arcades', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('arcade_type');
            $table->longtext('data')->nullable()->default(null);
            $table->longtext('output')->nullable()->default(null);
            $table->longtext('variable_data')->nullable()->default(null);
            $table->boolean('has_image')->default(0);
            $table->text('description')->nullable()->default(null);
            $table->text('parsed_description')->nullable()->default(null);
            $table->integer('sort')->unsigned()->default(0);
            $table->boolean('is_visible')->default(0);
            $table->integer('limit')->nullable()->default(null);
            $table->enum('limit_period', ['Hour', 'Day', 'Week', 'Month', 'Year'])->nullable()->default(null);
            $table->integer('currency_id')->unsigned()->nullable()->default(null);
            $table->integer('fee')->nullable()->default(null);
            $table->longtext('flavor_data')->nullable()->default(null);
        });

        //log where we can check the completion
        Schema::create('arcade_log', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('arcade_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
            $table->integer('character_id')->unsigned()->nullable()->default(null);
            //..i dont really see a use for this at this time, but could be usable for "pity" systems?
            $table->boolean('won')->default(0);
            $table->timestamps();
            $table->text('data')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('arcades');
        Schema::dropIfExists('arcade_log');
    }
}
