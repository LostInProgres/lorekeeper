<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('feature_associations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('object_id')->unsigned()->default(0);
            $table->string('object_type');
            $table->integer('association_id')->unsigned()->default(0);
            $table->string('association_type');
            $table->string('association_summary', 256)->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feature_associations');
    }
};
