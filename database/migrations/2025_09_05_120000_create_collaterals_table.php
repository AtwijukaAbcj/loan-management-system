<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void
    {
        Schema::create('collaterals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('loan_id');
            $table->unsignedBigInteger('borrower_id');
            $table->string('collateral_name');
            $table->string('item_description')->nullable();
            $table->decimal('item_value', 12, 2)->nullable();
            $table->string('item_type')->nullable();
            $table->string('document_path')->nullable();
            $table->timestamps();
            $table->foreign('loan_id')->references('id')->on('loans')->onDelete('cascade');
            $table->foreign('borrower_id')->references('id')->on('borrowers')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('collaterals');
    }
};
