<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('collaterals', function (Blueprint $table) {
            if (!Schema::hasColumn('collaterals', 'collateral_name')) {
                $table->string('collateral_name')->nullable()->after('borrower_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('collaterals', function (Blueprint $table) {
            if (Schema::hasColumn('collaterals', 'collateral_name')) {
                $table->dropColumn('collateral_name');
            }
        });
    }
};
