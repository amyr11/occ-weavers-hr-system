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
            $table->integer('e_contract_exp_rem_days')->virtualAs('CASE WHEN CURDATE() >= start_date AND CURDATE() < end_date THEN DATEDIFF(end_date, CURDATE()) ELSE NULL END');
            $table->integer('p_contract_exp_rem_days')->virtualAs('CASE WHEN CURDATE() >= start_date AND CURDATE() < paper_contract_end_date THEN DATEDIFF(paper_contract_end_date, CURDATE()) ELSE NULL END');
            $table->string('status')->virtualAs('CASE 
                WHEN CURDATE() < start_date THEN "Upcoming"
                WHEN CURDATE() >= start_date AND CURDATE() < end_date AND CURDATE() < paper_contract_end_date THEN "Active"
                WHEN CURDATE() >= end_date AND CURDATE() >= paper_contract_end_date THEN "Expired (Both)"
                WHEN CURDATE() >= end_date THEN "Expired (Electronic)"
                WHEN CURDATE() >= paper_contract_end_date THEN "Expired (Paper)"
            END');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            //
        });
    }
};
