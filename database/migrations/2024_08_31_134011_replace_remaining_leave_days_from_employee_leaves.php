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
            $table->dropColumn('remaining_leave_days');
            $table->integer('leave_remaining_days')->nullable()->virtualAs('CASE WHEN CURDATE() >= start_date AND CURDATE() <= end_date THEN DATEDIFF(end_date, CURDATE()) ELSE NULL END');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_leaves', function (Blueprint $table) {
            $table->integer('remaining_leave_days')->nullable();
            $table->dropColumn('leave_remaining_days');
        });
    }
};
