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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_number')->constrained('employees', 'employee_number')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('employee_job_id')->constrained();
            $table->date('start_date');
            $table->date('end_date');
            $table->date('paper_contract_end_date')->nullable();
            $table->integer('duration_in_years')->virtualAs('(DATEDIFF(end_date, start_date) + 1) / 365');
            $table->float('basic_salary');
            $table->float('housing_allowance')->nullable();
            $table->float('transportation_allowance')->nullable();
            $table->float('food_allowance')->nullable();
            $table->string('remarks')->nullable();
            $table->string('file_link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
