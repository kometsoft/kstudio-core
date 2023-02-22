<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        //User Permission
        Permission::updateOrCreate(['name' => 'user:add']);
        Permission::updateOrCreate(['name' => 'user:edit']);
        Permission::updateOrCreate(['name' => 'user:list']);

        //Data Dictionary Permission
        Permission::updateOrCreate(['name' => 'data-dictionary:add']);
        Permission::updateOrCreate(['name' => 'data-dictionary:edit']);
        Permission::updateOrCreate(['name' => 'data-dictionary:list']);

        
        // Create roles and assign created permissions
        $role_admin = Role::updateOrCreate(['name' => 'Admin'])
            ->syncPermissions([
                'user:add',
                'user:edit',
                'user:list'
            ]);

        // Create roles and assign created permissions
        $role_officer = Role::updateOrCreate(['name' => 'Officer'])
            ->syncPermissions([
            ]);

            User::find(1)->assignRole($role_admin);
            User::find(2)->assignRole($role_officer);
    }
}
