<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users you want to make super admins
        // Example: all users with email containing 'admin' or customize as needed
        // $users = User::where('email', 'like', '%admin%')->get();

        // Or simply assign to all users:
        $users = User::all();

        // Create the super_admin role if it doesn't exist
        $role = Role::firstOrCreate(['name' => 'super_admin']);

        // Assign all permissions to the super_admin role
        $permissions = Permission::all();
        $role->syncPermissions($permissions);

        // Assign the role to all selected users
        foreach ($users as $user) {
            $user->assignRole($role);
        }

        $this->command->info('Super admin role and all permissions assigned to all users.');
    }
}