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
            $table->integer('electronic_duration_in_years')->virtualAs('YEAR(end_date) - YEAR(start_date)');
            $table->integer('paper_duration_in_years')->virtualAs('YEAR(paper_contract_end_date) - YEAR(paper_contract_start_date)');
            $table->dropColumn('duration_in_days');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->integer('duration_in_days')->virtualAs('CASE WHEN start_date OR end_date THEN DATEDIFF(end_date, start_date) + 1 ELSE NULL END');
            $table->dropColumn('electronic_duration_in_years');
            $table->dropColumn('paper_duration_in_years');
        });
    }
};
