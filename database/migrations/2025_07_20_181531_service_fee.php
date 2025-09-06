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
           if (!Schema::hasColumn('loan_types', 'service_fee')) {
               $table->decimal('service_fee', 64, 0);
           }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loan_types', function (Blueprint $table) {
           if (Schema::hasColumn('loan_types', 'service_fee')) {
               $table->dropColumn('service_fee');
           }
        });
    }
};
