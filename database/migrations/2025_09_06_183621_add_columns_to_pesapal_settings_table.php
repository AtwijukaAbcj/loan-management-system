<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('pesapal_settings')) {
            // If the table somehow doesn't exist, create it with the right columns.
            Schema::create('pesapal_settings', function (Blueprint $table) {
                $table->id();
                $table->string('consumer_key')->nullable();
                $table->string('consumer_secret')->nullable();
                $table->boolean('is_active')->default(false);
                $table->timestamps();
            });

            return;
        }

        Schema::table('pesapal_settings', function (Blueprint $table) {
            if (! Schema::hasColumn('pesapal_settings', 'consumer_key')) {
                $table->string('consumer_key')->nullable()->after('id');
            }
            if (! Schema::hasColumn('pesapal_settings', 'consumer_secret')) {
                $table->string('consumer_secret')->nullable()->after('consumer_key');
            }
            if (! Schema::hasColumn('pesapal_settings', 'is_active')) {
                $table->boolean('is_active')->default(false)->after('consumer_secret');
            }
        });
    }

    public function down(): void
    {
        // requires doctrine/dbal (you already have it)
        if (Schema::hasTable('pesapal_settings')) {
            Schema::table('pesapal_settings', function (Blueprint $table) {
                if (Schema::hasColumn('pesapal_settings', 'is_active')) {
                    $table->dropColumn('is_active');
                }
                if (Schema::hasColumn('pesapal_settings', 'consumer_secret')) {
                    $table->dropColumn('consumer_secret');
                }
                if (Schema::hasColumn('pesapal_settings', 'consumer_key')) {
                    $table->dropColumn('consumer_key');
                }
            });
        }
    }
};
