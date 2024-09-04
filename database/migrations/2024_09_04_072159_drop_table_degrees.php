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
            $table->dropForeign(['degree_id']);
            $table->dropColumn('degree_id');
        });
        Schema::dropIfExists('degrees');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('degrees', function (Blueprint $table) {
            $table->id();
            $table->string('degree')->unique();
            $table->timestamps();
        });
        Schema::table('employees', function (Blueprint $table) {
            $table->foreignId('degree_id')->nullable()->constrained()->cascadeOnUpdate();
        });
    }
};
