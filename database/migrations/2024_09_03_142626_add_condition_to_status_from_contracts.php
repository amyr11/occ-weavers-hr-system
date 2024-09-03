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
            $table->string('status')->virtualAs('CASE 
                WHEN CURDATE() < start_date THEN "Upcoming"
                WHEN CURDATE() >= end_date AND CURDATE() >= paper_contract_end_date THEN "Expired (Both)"
                WHEN CURDATE() >= end_date THEN "Expired (Electronic)"
                WHEN CURDATE() >= paper_contract_end_date THEN "Expired (Paper)"
                WHEN end_date IS NULL THEN "No End Date"
                ELSE "Active"
            END')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->string('status')->virtualAs('CASE 
                WHEN CURDATE() < start_date THEN "Upcoming"
                WHEN CURDATE() >= end_date AND CURDATE() >= paper_contract_end_date THEN "Expired (Both)"
                WHEN CURDATE() >= end_date THEN "Expired (Electronic)"
                WHEN CURDATE() >= paper_contract_end_date THEN "Expired (Paper)"
                ELSE "Active"
            END')->change();
        });
    }
};
