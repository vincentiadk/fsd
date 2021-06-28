<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'name' => 'manager',
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'name' => 'operator scan',
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'name' => 'operator index',
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'name' => 'supervisor',
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'name' => 'client',
                'created_at' => now(), 
                'updated_at' => now()
            ],
        ]
        );
    }
}
