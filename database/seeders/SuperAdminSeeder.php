<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // 1) Create / update the user
        $email = env('SUPER_ADMIN_EMAIL', 'solichholdings@gmail.com');
        $password = env('SUPER_ADMIN_PASSWORD', 'admin123');

        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Super Admin',
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ]
        );

        // 2) Ensure a Super Admin role exists
        $role = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);

        // 3) Give the role every permission that exists
        $permissions = Permission::pluck('name')->all();
        if (! empty($permissions)) {
            $role->syncPermissions($permissions);
        }

        // 4) Assign the role to the user
        if (! $user->hasRole($role->name)) {
            $user->assignRole($role->name);
        }

        // Optional: set boolean flag if column exists
        if (\Schema::hasColumn($user->getTable(), 'is_admin')) {
            $user->forceFill(['is_admin' => true])->save();
        }

        // Safe logs when running via Artisan
        $this->command?->info('Super admin role assigned to: ' . $email);
        $this->command?->warn('Login with: ' . $email . ' / ' . $password . ' (or set SUPER_ADMIN_* in .env)');
    }
}