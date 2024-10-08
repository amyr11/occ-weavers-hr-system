<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update any NULL values to the default values
        DB::table('employees')
            ->whereNull('max_leave_days')
            ->update(['max_leave_days' => 21]);

        DB::table('employees')
            ->whereNull('current_leave_days')
            ->update(['current_leave_days' => 0]);

        Schema::table('employees', function (Blueprint $table) {
            $table->integer('max_leave_days')->default(21)->nullable(false)->change();
            $table->integer('current_leave_days')->default(0)->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->integer('max_leave_days')->default(null)->nullable()->change();
            $table->integer('current_leave_days')->default(null)->nullable()->change();
        });
    }
};
