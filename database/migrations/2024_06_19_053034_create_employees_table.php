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

            // Personal Information
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('suffix')->nullable();
            $table->string('full_name')->virtualAs('CONCAT(first_name, " ", middle_name, " ", last_name, " ", suffix)');
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
            $table->date('iqama_expiration');
            $table->string('passport_number')->unique();
            $table->date('passport_date_issue');
            $table->date('passport_expiration');
            $table->date('sce_expiration');
            $table->string('insurance_classification');

            // Company information
            $table->date('company_start_date');
            $table->date('final_exit_date')->nullable();
            $table->date('visa_expired_date')->nullable();
            $table->date('transferred_date')->nullable();
            $table->integer('max_leave_days'); // not sure
            $table->integer('current_leave_days'); // not sure

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
