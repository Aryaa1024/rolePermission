<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PermissionSyncScheduler extends Command
{
    protected $signature = 'permissions:sync';
    protected $description = 'Sync admin routes as permissions and ensure SuperAdmin role and user.';

    public function handle()
    {
        $routes = collect(Route::getRoutes())->filter(fn($route) => str_starts_with($route->getName(), 'admin.'));
        foreach ($routes as $route) {
            $permissionName = $route->getName();
            if (!Permission::where('name', $permissionName)->exists()) {
                Permission::create(['name' => $permissionName, 'guard_name' => 'web']);
            }
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
        Artisan::call('optimize:clear');

        $superAdminRole = Role::firstOrCreate(['name' => 'SuperAdmin', 'guard_name' => 'web']);
        $permissions = Permission::pluck('name')->toArray();
        $superAdminRole->syncPermissions($permissions);

        $superAdminUser = User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
            ]
        );

        if (!$superAdminUser->hasRole('SuperAdmin')) {
            $superAdminUser->assignRole($superAdminRole);
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
        $this->info('Permissions synced and SuperAdmin verified successfully.');
    }
}
