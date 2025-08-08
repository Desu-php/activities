<?php

namespace Database\Seeders;

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (PermissionEnum::cases() as $permission) {
            Permission::firstOrCreate([
                'name' => $permission->value,
                'guard_name' => config('auth.defaults.guard'),
            ]);
        }

        foreach (RoleEnum::cases() as $role) {
            $roleModel = Role::firstOrCreate([
                'name' => $role->value,
                'guard_name' => config('auth.defaults.guard')
            ]);

            $roleModel->givePermissionTo($role->getPermissions());
        }
    }
}
