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
        Schema::create('employees', function (Blueprint $table) {
            $table->id('employee_number');

            // Relationships
            $table->foreignId('country_id')->constrained()->cascadeOnUpdate();
            $table->foreignId('insurance_class_id')->constrained()->cascadeOnUpdate();
            $table->foreignId('education_level_id')->constrained()->cascadeOnUpdate();
            $table->foreignId('degree_id')->nullable()->constrained()->cascadeOnUpdate();
            $table->foreignId('employee_job_id')->nullable()->constrained()->cascadeOnUpdate();
            $table->foreignId('project_id')->nullable()->constrained()->cascadeOnUpdate();

            // Personal Information
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('suffix')->nullable();
            $table->string('full_name')->virtualAs('CONCAT(first_name, " ", COALESCE(middle_name, ""), " ", last_name, CASE WHEN suffix IS NOT NULL AND suffix != "" THEN CONCAT(" ", suffix) ELSE "" END)');
            $table->date('birthdate');
            $table->integer('age')->virtualAs('TIMESTAMPDIFF(YEAR, birthdate, CURDATE())');
            $table->string('mobile_number');
            $table->string('email')->unique();
            $table->string('photo_link')->nullable();

            // Education
            $table->date('college_graduation_date');

            // Government information
            $table->string('labor_office_number')->unique();
            $table->string('iban_number')->unique();
            $table->string('iqama_number')->unique();
            $table->string('iqama_job_title');
            $table->string('iqama_expiration_hijri');
            $table->date('iqama_expiration_gregorian')->nullable();
            $table->integer('iqama_expiration_remaining_days')->virtualAs('CASE WHEN CURDATE() <= iqama_expiration_gregorian THEN DATEDIFF(iqama_expiration_gregorian, CURDATE()) ELSE NULL END');
            $table->string('passport_number')->unique();
            $table->date('passport_date_issue');
            $table->date('passport_expiration');
            $table->date('sce_expiration');

            // Company information
            $table->date('company_start_date');
            $table->date('electronic_contract_start_date')->nullable();
            $table->date('electronic_contract_end_date')->nullable();
            $table->date('paper_contract_end_date')->nullable();
            $table->date('final_exit_date')->nullable();
            $table->date('visa_expired_date')->nullable();
            $table->date('transferred_date')->nullable();
            $table->string('status')->virtualAs('IF(final_exit_date IS NOT NULL, "Final Exit", IF(visa_expired_date IS NOT NULL, "Visa Expired", IF(transferred_date IS NOT NULL, "Transferred", "Active")))');
            $table->integer('max_leave_days');
            $table->integer('current_leave_days')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
