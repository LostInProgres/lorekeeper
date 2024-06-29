<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('user_settings', function (Blueprint $table) {
            $table->boolean('site_fonts_disabled')->default(0);
            $table->decimal('font_size', 2, 1)->default('01.0');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('user_settings', function (Blueprint $table) {
            $table->dropColumn('site_fonts_disabled');
            $table->dropColumn('font_size');
        });
    }
};
