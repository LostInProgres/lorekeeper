<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCurrencyCap extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('arcade_log', function (Blueprint $table) {
            $table->integer('currency_earned')->nullable()->default(null);
        });

        Schema::table('arcades', function (Blueprint $table) {
            $table->integer('currency_cap')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('arcade_log', function (Blueprint $table) {
            $table->dropColumn('currency_earned');
        });

         Schema::table('arcades', function (Blueprint $table) {
            $table->dropColumn('currency_cap');
        });
    }
}
