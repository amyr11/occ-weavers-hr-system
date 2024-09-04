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
        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign(['education_level_id']);
            $table->dropColumn('education_level_id');
        });
        Schema::dropIfExists('education_levels');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('education_levels', function (Blueprint $table) {
            $table->id();
            $table->string('level')->unique();
            $table->timestamps();
        });
        Schema::table('employees', function (Blueprint $table) {
            $table->foreignId('education_level_id')->nullable()->constrained()->cascadeOnUpdate();
        });
    }
};
