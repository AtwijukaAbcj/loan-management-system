<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('collaterals', function (Blueprint $table) {
            if (!Schema::hasColumn('collaterals', 'borrower_id')) {
                $table->unsignedBigInteger('borrower_id')->nullable()->after('loan_id');
                $table->foreign('borrower_id')->references('id')->on('borrowers')->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('collaterals', function (Blueprint $table) {
            if (Schema::hasColumn('collaterals', 'borrower_id')) {
                $table->dropForeign(['borrower_id']);
                $table->dropColumn('borrower_id');
            }
        });
    }
};
