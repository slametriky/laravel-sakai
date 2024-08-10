<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superadmin = Role::create([
            'name'          => 'superadmin'
        ]);
        $superadmin->givePermissionTo([
            'delete user',
            'update user',
            'read user',
            'create user',
            'delete role',
            'update role',
            'read role',
            'create role',
            'delete permission',
            'update permission',
            'read permission',
            'create permission'
        ]);
        $admin = Role::create([
            'name'          => 'admin'
        ]);
        $admin->givePermissionTo([
            'delete user',
            'update user',
            'read user',
            'create user',
            'read role',
            'read permission',
        ]);
        $operator = Role::create([
            'name'          => 'operator'
        ]);
        
        $operator->givePermissionTo([
            'read user',
            'create user',
            'read role',
            'read permission',
        ]);
    }
}
