<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $role = Role::firstOrCreate(
            ['name' => 'SuperAdmin'],
            ['guard_name' => 'web']
        );

        $admin = User::firstOrCreate(
            ['email' => 'superadmin@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('123456'),
            ]
        );

        if (! $admin->hasRole($role->name)) {
            $admin->assignRole($role);
        }

        if (method_exists($admin, 'assignPermissionAll')) {
            $admin->assignPermissionAll();
        }
    }
}
