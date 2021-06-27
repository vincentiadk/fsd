<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use App\Models\Nasabah;
use App\Models\Kabupaten;
use App\Models\Provinsi;
use App\Models\Kecamatan;
use App\Models\Kelurahan;

class NasabahImport implements ToCollection, WithStartRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach($rows as $row) {
            if(Nasabah::where('no_rek', $row[2])->count() < 1) {
                $provinsi = Provinsi::where('name', $row[28])->first();
                $provinsi_id = "";
                \Log::info($row[2]);
                if($provinsi) {
                    $provinsi_id = $provinsi->id;
                }

                $kab = Kabupaten::where('name', 'LIKE', str_replace('KOTA ', '', $row[27]))
                    ->where('provinsi_id', $provinsi_id)
                    ->first();
                $kab_id = null;
                if($kab) {
                    $kab_id = $kab->id;
                }

                $kec = Kecamatan::where('name', $row[26])
                    ->where('kabupaten_id', $kab_id)
                    ->first();
                $kec_id = null;
                if($kec) {
                    $kec_id = $kec->id;
                }

                $kel = Kelurahan::where('name', $row[25])
                    ->where('kecamatan_id', $kec_id)
                    ->first();
                $kel_id = null;
                if($kel) {
                    $kel_id = $kel->id;
                }

                $provinsi_darurat = Provinsi::where('name', $row[47])->first();
                $provinsi_darurat_id = null;
                if($provinsi_darurat) {
                    $provinsi_darurat_id = $provinsi_darurat->id;
                }

                $kab_darurat = Kabupaten::where('name', 'LIKE', str_replace('KOTA ', '', $row[46]))
                    ->where('provinsi_id', $provinsi_darurat_id)
                    ->first();
                $kab_darurat_id = null;
                if($kab_darurat) {
                    $kab_darurat_id = $kab_darurat->id;
                }

                Nasabah::create([
                    'cif'               => $row[0],
                    'cab'               => $row[1],
                    'no_rek'            => $row[2],
                    'status_rek'        => explode(':', $row[3])[0],
                    'risiko'            => explode(':', $row[4])[0],
                    'tgl_buka'          => $row[5],
                    'golongan_nasabah'  => explode(':', $row[6])[0],
                    'bi_gol_pajak'      => explode(':', $row[7])[0],
                    'bi_hub_bank'       => explode(':', $row[8])[0], 
                    'nama'              => $row[9],
                    'jenis_kelamin'     => explode(':', $row[10])[0], 
                    'kebangsaan'        => explode(':', $row[11])[0], 
                    'tempat_lahir'      => $row[12],
                    'tgl_lahir'         => $row[13],
                    'no_identitas'      => $row[14],
                    'masa_berlaku_identitas'    => $row[15],
                    'npwp'              => $row[16],
                    'nama_ibu_kandung'  => $row[17],
                    'status_kawin'      => explode(':', $row[18])[0], 
                    'agama'             => explode(':', $row[19])[0], 
                    'pendidikan'        => $row[20],
                    'alamat_1'          => $row[21],
                    'alamat_2'          => $row[22],
                    'rt'                => $row[23],
                    'rw'                => $row[24],
                    'kelurahan_id'      => $kel_id,
                    'kecamatan_id'      => $kec_id,
                    'kabupaten_id'      => $kab_id,
                    'provinsi_id'       => $provinsi_id,
                    'kodepos'           => $row[29],
                    'status_rumah'      => explode(':', $row[30])[0], 
                    'telp_hp'           => $row[31],
                    'telp_rumah'        => $row[32],
                    'alamat_surat'      => explode(':', $row[33])[0], 
                    'tipe_alamat'       => explode(':', $row[34])[0], 
                    'pekerjaan'         => explode(':', $row[35])[0],
                    'kode_profesi'      => explode(':', $row[36])[0],
                    'status_pekerjaan'  => explode(':', $row[37])[0], 
                    'nama_instansi'     => $row[38],
                    'alamat_instansi'   => $row[39],
                    'kodepos_instansi'  => $row[40],
                    'telp_instansi'     => $row[41],
                    'suami_istri'       => $row[42],
                    'nama_kontak_darurat'   => $row[43],
                    'hubungan_darurat'  => explode(':', $row[44])[0], 
                    'alamat_darurat'    => $row[45],
                    'darurat_kabupaten_id'  => $kab_darurat_id,
                    'darurat_provinsi_id'   => $provinsi_darurat_id,
                    'telp_darurat'          => $row[48],
                    'sumber_dana'           => explode(':', $row[49])[0], 
                    'tujuan_penggunaan_dana'=> explode(':', $row[50])[0], 
                    'penghasilan_tahunan'   => explode(':', $row[51])[0], 
                    'penghasilan_tambahan_tahunan'=> explode(':', $row[52])[0], 
                    'jml_setoran'       => explode(':', $row[53])[0], 
                    'jml_tarikan'       => explode(':', $row[54])[0], 
                    'maks_setor'        => $row[55],
                    'maks_tarik'        => $row[56],
                    'kode_dinas'        => $row[57],
                    'cncdbi'            => explode(':', $row[58])[0], 
                    'cncdu6'            => explode(':', $row[59])[0], 
                    'cnbi10'            => explode(':', $row[60])[0],
                    'cargcd'            => explode(':', $row[61])[0],
                    'cnxh03'            => $row[62]
                ]);
            }
        }
    }

    public function startRow(): int
    {
        return 3;
    }
}
