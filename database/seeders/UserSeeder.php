<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Vincentia Dyah K',
                'username' => 'superadmin',
                'password' => Hash::make('superadmin'),
                'email' => 'vincentiadksitanggang@gmail.com',
                'email_verified_at' => now(),
                'role_id' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Nama Manager',
                'username' => 'manager',
                'password' => Hash::make('manager'),
                'email' => 'vdkmanager@gmail.com',
                'email_verified_at' => now(),
                'role_id' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Nama Operator Upload',
                'username' => 'upload',
                'password' => Hash::make('upload'),
                'email' => 'vdkupload@gmail.com',
                'email_verified_at' => now(),
                'role_id' => '3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Nama Operator Index',
                'username' => 'index',
                'password' => Hash::make('index'),
                'email' => 'vdkindex@gmail.com',
                'email_verified_at' => now(),
                'role_id' => '4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Nama Operator Supervisor',
                'username' => 'supervisor',
                'password' => Hash::make('supervisor'),
                'email' => 'vdkspv@gmail.com',
                'email_verified_at' => now(),
                'role_id' => '5',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Nama Client',
                'username' => 'client',
                'password' => Hash::make('client'),
                'email' => 'vdkclient@gmail.com',
                'email_verified_at' => now(),
                'role_id' => '6',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
