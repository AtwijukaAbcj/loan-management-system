<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Update roles table
        DB::table('roles')->where('guard_name', '')->update(['guard_name' => 'web']);
        // Update permissions table
        DB::table('permissions')->where('guard_name', '')->update(['guard_name' => 'web']);
    }

    public function down(): void
    {
        // Optionally revert back to empty string
        DB::table('roles')->where('guard_name', 'web')->update(['guard_name' => '']);
        DB::table('permissions')->where('guard_name', 'web')->update(['guard_name' => '']);
    }
};
