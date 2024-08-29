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
            $table->foreignId('country_id')->nullable()->constrained()->cascadeOnUpdate();
            $table->foreignId('insurance_class_id')->nullable()->constrained()->cascadeOnUpdate();
            $table->foreignId('education_level_id')->nullable()->constrained()->cascadeOnUpdate();
            $table->foreignId('degree_id')->nullable()->constrained()->cascadeOnUpdate();
            $table->foreignId('employee_job_id')->nullable()->constrained()->cascadeOnUpdate();
            $table->foreignId('project_id')->nullable()->constrained()->cascadeOnUpdate();

            // Personal Information
            $table->string('full_name');
            $table->date('birthdate')->nullable();
            $table->integer('age')->nullable()->virtualAs('TIMESTAMPDIFF(YEAR, birthdate, CURDATE())');
            $table->string('mobile_number')->nullable();
            $table->string('email')->nullable();
            $table->string('photo_link')->nullable();

            // Education
            $table->date('college_graduation_date')->nullable();

            // Government information
            $table->string('labor_office_number')->nullable();
            $table->string('iban_number')->nullable();
            $table->string('iqama_number')->nullable();
            $table->string('iqama_job_title')->nullable();
            $table->string('iqama_expiration_hijri')->nullable();
            $table->date('iqama_expiration_gregorian')->nullable();
            $table->integer('iqama_expiration_remaining_days')->nullable()->virtualAs('CASE WHEN CURDATE() <= iqama_expiration_gregorian THEN DATEDIFF(iqama_expiration_gregorian, CURDATE()) ELSE NULL END');
            $table->string('passport_number')->nullable();
            $table->date('passport_date_issue')->nullable();
            $table->date('passport_expiration')->nullable();
            $table->date('sce_expiration')->nullable();

            // Company information
            $table->date('company_start_date')->nullable();
            $table->date('electronic_contract_start_date')->nullable();
            $table->date('electronic_contract_end_date')->nullable();
            $table->date('paper_contract_end_date')->nullable();
            $table->date('final_exit_date')->nullable();
            $table->date('visa_expired_date')->nullable();
            $table->date('transferred_date')->nullable();
            $table->string('status')->nullable()->virtualAs('IF(final_exit_date IS NOT NULL, "Final Exit", IF(visa_expired_date IS NOT NULL, "Visa Expired", IF(transferred_date IS NOT NULL, "Transferred", "Active")))');
            $table->integer('max_leave_days')->nullable();
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
