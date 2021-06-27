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
                'username' => 'vincentiadk',
                'password' => Hash::make('iamcak3p'),
                'email' => 'vincentiadksitanggang@gmail.com',
                'email_verified_at' => now(),
                'role_id' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Vincentia Scan',
                'username' => 'scan',
                'password' => Hash::make('iamcak3p'),
                'email' => 'vdkscan@gmail.com',
                'email_verified_at' => now(),
                'role_id' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Vincentia Index',
                'username' => 'index',
                'password' => Hash::make('iamcak3p'),
                'email' => 'vdkindex@gmail.com',
                'email_verified_at' => now(),
                'role_id' => '3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Vincentia Supervisor',
                'username' => 'supervisor',
                'password' => Hash::make('iamcak3p'),
                'email' => 'vdkspv@gmail.com',
                'email_verified_at' => now(),
                'role_id' => '4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Vincentia Client',
                'username' => 'client',
                'password' => Hash::make('iamcak3p'),
                'email' => 'vdkclient@gmail.com',
                'email_verified_at' => now(),
                'role_id' => '5',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
