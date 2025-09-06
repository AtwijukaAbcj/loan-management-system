<?php
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
        $email = env('SUPER_ADMIN_EMAIL', 'admin@yourdomain.com');
        $password = env('SUPER_ADMIN_PASSWORD', 'ChangeMe123!');

        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Super Admin',
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ]
        );

        // 2) Ensure a Super Admin role exists (Spatie/Permission)
        //    Use the same guard as your User model (usually "web")
        $role = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);

        // 3) Make sure all permissions exist (Shield usually generates these)
        //    Then give the role every permission
        $permissions = Permission::pluck('name')->all();
        if (!empty($permissions)) {
            $role->syncPermissions($permissions);
        }

        // 4) Assign the role to the user
        if (!$user->hasRole($role->name)) {
            $user->assignRole($role->name);
        }

        // Optional: if your app checks a boolean like `is_admin`
        if ($user->isFillable('is_admin') || \Schema::hasColumn($user->getTable(), 'is_admin')) {
            $user->forceFill(['is_admin' => true])->save();
        }

        $this->command->info('Super admin role assigned to user: '.$email.' with all permissions.');
        $this->command->warn('Login with: '.$email.' / '.$password.' (or set SUPER_ADMIN_EMAIL/PASSWORD in .env)');
    }
}
        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Super Admin',
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ]
        );

        // 2) Ensure a Super Admin role exists (Spatie/Permission)
        //    Use the same guard as your User model (usually "web")
        $role = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);

        // 3) Make sure all permissions exist (Shield usually generates these)
        //    Then give the role every permission
        $permissions = Permission::pluck('name')->all();
        if (!empty($permissions)) {
            $role->syncPermissions($permissions);
        }

        // 4) Assign the role to the user
        if (!$user->hasRole($role->name)) {
            $user->assignRole($role->name);
        }

        // Optional: if your app checks a boolean like `is_admin`
        if ($user->isFillable('is_admin') || \Schema::hasColumn($user->getTable(), 'is_admin')) {
            $user->forceFill(['is_admin' => true])->save();
        }

        $this->command->info('Super admin role assigned to user: '.$email.' with all permissions.');
        $this->command->warn('Login with: '.$email.' / '.$password.' (or set SUPER_ADMIN_EMAIL/PASSWORD in .env)');
    }
}
