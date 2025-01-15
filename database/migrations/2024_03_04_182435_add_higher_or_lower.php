<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHigherOrLower extends Migration {
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::table('user_settings', function (Blueprint $table) {
            $table->integer('hol_plays')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() {
        //
    }
}
