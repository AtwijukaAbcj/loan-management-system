<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('pesapal_settings')) {
            Schema::create('pesapal_settings', function (Blueprint $table) {
                $table->id();
                $table->string('consumer_key');
                $table->string('consumer_secret');
                $table->boolean('is_active')->default(false);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('pesapal_settings');
    }
};
