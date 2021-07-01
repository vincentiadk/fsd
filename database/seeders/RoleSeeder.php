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
                'name' => 'Super Admin',
                'permissions'=> json_encode(['all']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'manager',
                'permissions' => json_encode([
                    'dashboard-manager',
                    'reporting',
                    'provinsi',
                    'kabupaten',
                    'kecamatan',
                    'kelurahan',
                    'import',
                    'performance',
                    'export-performance',
                    'role',
                    'user',
                    'tambah-update-user',
                    'enable-user',
                    'export',
                    'disable-user',
                    'view-nasabah',
                    'set-lapor',
                    'role',
                    'simpan-role',
                    'view-permission',
                    'simpan-permission'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'operator scan',
                'permissions' => json_encode([
                    'dashboard-upload',
                    'upload',
                    'map',
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'operator index',
                'permissions' => json_encode([
                    'dashboard-index',
                    'indexing',
                    'indexing-simpan'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'supervisor',
                'permissions' => json_encode([
                    'dashboard-supervisor',
                    'qc',
                    'qc-simpan'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'client',
                'permissions' => json_encode(['dashboard-client']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]
        );
    }
}
