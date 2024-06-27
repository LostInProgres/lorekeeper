<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotepad extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_settings', function(Blueprint $table) {
            $table->text('notepad')->nullable()->default(null);
            $table->text('parsed_notepad')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_settings', function(Blueprint $table) {
            $table->dropColumn('notepad');
            $table->dropColumn('parsed_notepad');
        });
    }
}
