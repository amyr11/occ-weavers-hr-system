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
            $table->integer('remaining_leave_days')->nullable();
            $table->integer('visa_duration_in_days');
            $table->date('visa_expiration');
            $table->integer('visa_remaining_days')->nullable()->virtualAs('CASE WHEN CURDATE() >= start_date AND CURDATE() <= visa_expiration THEN DATEDIFF(visa_expiration, CURDATE()) ELSE NULL END');
            $table->string('contact_number')->nullable();
            $table->boolean('arrived')->default(false);
            $table->string('status')->virtualAs('CASE 
                WHEN arrived = true THEN "Arrived (Resolved)"
                WHEN CURDATE() < start_date THEN "For vacation" 
                WHEN CURDATE() >= start_date AND CURDATE() <= end_date THEN "On vacation" 
                WHEN CURDATE() > end_date AND CURDATE() < visa_expiration THEN "Arrival expected" 
                WHEN CURDATE() > visa_expiration AND arrived = false THEN "Visa expired" 
            END');
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
