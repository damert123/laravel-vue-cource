<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSedder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'create',
            'read',
            'update',
            'delete'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $permissions = Permission::all();
        $roles = Role::all();

        foreach ($roles as $role) {
            foreach ($permissions as $permission) {
                $role->permissions()->syncWithoutDetaching($permission->id);
            }
        }

    }
}
