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
        Schema::dropIfExists('project_assignments');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('project_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_number')->constrained('employees', 'employee_number')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('project_id')->constrained();
            $table->date('transfer_date');
            $table->string('transfer_memo_link')->nullable();
            $table->timestamps();
        });
    }
};
