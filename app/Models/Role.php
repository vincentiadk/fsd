<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'permissions',
    ];

    public static function roles()
    {
        return [
            'dashboard' => [
                'dashboard-manager' => 'Dashboard Manager',
                'dashboard-client' => 'Dashboard Client',
                'dashboard-index' => 'Dashboard Indexing',
                'dashboard-supervisor' => 'Dashboard Supervisor',
                'dashboard-upload' => 'Dashboard Upload',
            ],
            'upload' => 'Upload File Nasabah dalam PDF',
            'map' => 'Map Simpan',
            'indexing' => 'Indexing',
            'indexing-simpan' => 'Simpan Indexing',
            'qc' => 'QC',
            'qc-simpan' => 'Simpan QC',
            'reporting' => 'Reporting Nasabah',
            'view-nasabah' => 'Lihat Data Nasabah',
            'set-lapor' => 'Set Tanggal Lapor',
            'import' => 'Import Database',
            'export' => 'Export Nasabah',
            'performance' => 'Laporan Kinerja User',
            'export-performance' => 'Export Laporan Kinerja User',
            'provinsi' => 'Master Provinsi',
            'kabupaten' => 'Master Kabupaten',
            'kecamatan' => 'Master Kecamatan',
            'kelurahan' => 'Master Kelurahan',
            'user' => 'User Management',
            'tambah-update-user' => 'Tambah dan Update User',
            'enable-user' => 'Enable User',
            'disable-user' => 'Disable User',
            'role' => 'Role Management',
            'simpan-role' => 'Simpan / Update Role',
            'view-permission' => 'Lihat Hak Akses',
            'simpan-permission' => 'Simpan / Update Hak Akses',
            
        ];
    }
}
