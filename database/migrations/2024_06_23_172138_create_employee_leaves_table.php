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
        Schema::create('employee_leaves', function (Blueprint $table) {
            $table->id();
            $table->string('request_file_link')->nullable();
            $table->foreignId('employee_number')->constrained('employees', 'employee_number')->cascadeOnDelete()->cascadeOnUpdate();
            $table->date('start_date');
            $table->date('end_date');
            // $table->integer('duration_in_days')->virtualAs('DATEDIFF(end_date, start_date) + 1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_leaves');
    }
};
