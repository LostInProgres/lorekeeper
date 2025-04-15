<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSortToUserAwardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_awards', function (Blueprint $table) {
            $table->integer('sort')->unsigned()->default(0);
            $table->boolean('is_visible')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_awards', function (Blueprint $table) {
            Schema::dropIfExists('sort');
            Schema::dropIfExists('is_visible');
        });
    }
}
