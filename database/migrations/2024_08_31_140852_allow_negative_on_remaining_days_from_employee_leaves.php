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
        Schema::table('employee_leaves', function (Blueprint $table) {
            $table->integer('visa_remaining_days')->nullable()->virtualAs('CASE WHEN CURDATE() >= start_date THEN DATEDIFF(visa_expiration, CURDATE()) ELSE NULL END')->change();
            $table->integer('leave_remaining_days')->nullable()->virtualAs('CASE WHEN CURDATE() >= start_date THEN DATEDIFF(end_date, CURDATE()) ELSE NULL END')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_leaves', function (Blueprint $table) {
            $table->integer('visa_remaining_days')->nullable()->virtualAs('CASE WHEN CURDATE() >= start_date AND CURDATE() <= visa_expiration THEN DATEDIFF(visa_expiration, CURDATE()) ELSE NULL END')->change();
            $table->integer('leave_remaining_days')->nullable()->virtualAs('CASE WHEN CURDATE() >= start_date AND CURDATE() <= end_date THEN DATEDIFF(end_date, CURDATE()) ELSE NULL END')->change();
        });
    }
};
