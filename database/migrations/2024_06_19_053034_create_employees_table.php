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
            $table->id('employee_no');

            // Relationships
            $table->foreignId('employee_status_id')->constrained();

            // Personal Information
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('suffix')->nullable();
            $table->date('birthdate');
            $table->int('age')->virtualAs('YEAR(CURDATE()) - YEAR(birthdate)');
            $table->string('mobile_number');
            $table->string('email')->unique();
            $table->string('photo_link')->nullable();

            // Education
            $table->date('college_graduation_date');

            // Government information
            $table->string('labor_office_num')->unique();
            $table->string('iban_num')->unique();
            $table->string('iqama_num')->unique();
            $table->string('iqama_job_title');
            $table->date('iqama_expiration');
            $table->string('passport_num')->unique();
            $table->date('passport_date_issue');
            $table->date('passport_expiration');
            $table->date('sce_expiration');
            $table->string('insurance_classification');

            // Company information
            $table->date('company_start_date');
            $table->int('max_leave_days'); // not sure
            $table->int('current_leave_days'); // not sure

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
