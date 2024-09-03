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
            $table->integer('e_contract_exp_rem_days')->virtualAs('CASE WHEN CURDATE() < end_date AND DATEDIFF(end_date, CURDATE()) > 0 THEN DATEDIFF(end_date, CURDATE()) ELSE NULL END')->change();
            $table->integer('p_contract_exp_rem_days')->virtualAs('CASE WHEN CURDATE() < paper_contract_end_date AND DATEDIFF(paper_contract_end_date, CURDATE()) > 0 THEN DATEDIFF(paper_contract_end_date, CURDATE()) ELSE NULL END')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->integer('e_contract_exp_rem_days')->virtualAs('CASE WHEN CURDATE() >= start_date AND CURDATE() < end_date THEN DATEDIFF(end_date, CURDATE()) ELSE NULL END')->change();
            $table->integer('p_contract_exp_rem_days')->virtualAs('CASE WHEN CURDATE() >= start_date AND CURDATE() < paper_contract_end_date THEN DATEDIFF(paper_contract_end_date, CURDATE()) ELSE NULL END')->change();
        });
    }
};
