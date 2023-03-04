<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //Pre insert to features table
        DB::table('features')->insert([
            ['name' => 'role'],
            ['name' => 'user'],
            [ 'name' => '(export csv/export excel/print/pdf)buttons on tables']
        ]);

        //Pre insert to features table
        DB::table('permissions')->insert([
            ['name' => 'view', 'feature_id' => '1'],
            ['name' => 'create', 'feature_id' => '1'],
            ['name' => 'edit', 'feature_id' => '1'],
            ['name' => 'delete', 'feature_id' => '1'],
            ['name' => 'view', 'feature_id' => '2'],
            ['name' => 'create', 'feature_id' => '2'],
            ['name' => 'edit', 'feature_id' => '2'],
            ['name' => 'delete', 'feature_id' => '2'],
            ['name' => 'view', 'feature_id' => '3']
        ]);

        //Create default SystemAdministrator role
        DB::table('roles')->insert(['name' => 'SystemAdministrator']);

        //Create default SystemAdministrator role for permissions
        DB::table('role_permissions')->insert([
            ['role_id' => '1', 'permissions_id' => '1'],
            ['role_id' => '1', 'permissions_id' => '2'],
            ['role_id' => '1', 'permissions_id' => '3'],
            ['role_id' => '1', 'permissions_id' => '4'],
            ['role_id' => '1', 'permissions_id' => '5'],
            ['role_id' => '1', 'permissions_id' => '6'],
            ['role_id' => '1', 'permissions_id' => '7'],
            ['role_id' => '1', 'permissions_id' => '8'],
            ['role_id' => '1', 'permissions_id' => '9']
        ]);

        //Create default user account
        DB::table('users')->insert([
            'name' => 'Administrator',
            'username' => 'admin',
            'role_id' => 1,
            'phone' => 0,
            'email' => 'picosbs@mail.com',
            'password' => Hash::make('picosbs'),
            'gender' => 0,
            'is_active' => 1,
        ]);


    }
}
