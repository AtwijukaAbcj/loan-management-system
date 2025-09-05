<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find the first user (customize as needed)
        $user = User::first();
        if (!$user) {
            $this->command->error('No users found. Please create a user first.');
            return;
        }

    // Create the super_admin role if it doesn't exist
    $role = Role::firstOrCreate(['name' => 'super_admin']);

    // Assign all permissions to the super_admin role
    $permissions = \Spatie\Permission\Models\Permission::all();
    $role->syncPermissions($permissions);

    // Assign the role to the user
    $user->assignRole($role);
    $this->command->info('Super admin role assigned to user: ' . $user->email . ' with all permissions.');
    }
}
