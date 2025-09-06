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
        Schema::table('loan_types', function (Blueprint $table) {
            if (!Schema::hasColumn('loan_types', 'service_fee_type')) {
                $table->string('service_fee_type')->nullable();
            }
            if (!Schema::hasColumn('loan_types', 'service_fee_percentage')) {
                $table->decimal('service_fee_percentage', 64, 2);
            }
            if (!Schema::hasColumn('loan_types', 'service_fee_custom_amount')) {
                $table->decimal('service_fee_custom_amount', 64, 2);
            }
            if (!Schema::hasColumn('loan_types', 'penalty_fee_type')) {
                $table->string('penalty_fee_type')->nullable();
            }
            if (!Schema::hasColumn('loan_types', 'penalty_fee_percentage')) {
                $table->decimal('penalty_fee_percentage', 64, 2);
            }
            if (!Schema::hasColumn('loan_types', 'penalty_fee_custom_amount')) {
                $table->decimal('penalty_fee_custom_amount', 64, 2);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loan_types', function (Blueprint $table) {
            //
        });
    }
};
