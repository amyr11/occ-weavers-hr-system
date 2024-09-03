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
        Schema::table('contracts', function (Blueprint $table) {
            $table->date('start_date')->nullable()->change();
            $table->date('end_date')->nullable()->change();
            $table->dropColumn('duration_in_years');
            $table->integer('duration_in_days')->virtualAs('CASE WHEN start_date OR end_date THEN DATEDIFF(end_date, start_date) + 1 ELSE NULL END');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->date('start_date')->nullable(false)->change();
            $table->date('end_date')->nullable(false)->change();
            $table->integer('duration_in_years')->virtualAs('(DATEDIFF(end_date, start_date) + 1) / 365');
            $table->dropColumn('duration_in_days');
        });
    }
};
