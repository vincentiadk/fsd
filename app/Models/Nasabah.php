<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nasabah extends Model
{
    use HasFactory;
    protected $table = 'nasabah';
    protected $fillable = [
        'cif',
        'no_rek',
        'cab',
        'status_rek',
        'risiko',
        'tgl_buka',
        'golongan_nasabah',
        'bi_gol_pajak',
        'bi_hub_bank',
        'nama',
        'jenis_kelamin',
        'kebangsaan',
        'tempat_lahir',
        'tgl_lahir',
        'no_identitas',
        'masa_berlaku_identitas',
        'npwp',
        'nama_ibu_kandung',
        'status_kawin',
        'agama',
        'pendidikan',
        'alamat_1',
        'alamat_2',
        'rt',
        'rw',
        'provinsi_id',
        'kabupaten_id',
        'kecamatan_id',
        'kelurahan_id',
        'kodepos',
        'status_rumah',
        'telp_hp',
        'telp_rumah',
        'alamat_surat',
        'tipe_alamat',
        'pekerjaan',
        'kode_profesi',
        'status_pekerjaan',
        'nama_instansi',
        'alamat_instansi',
        'kodepos_instansi',
        'telp_instansi',
        'suami_istri',
        'nama_kontak_darurat',
        'hubungan_darurat',
        'alamat_darurat',
        'darurat_provinsi_id',
        'darurat_kabupaten_id',
        'telp_darurat',
        'sumber_dana',
        'tujuan_penggunaan_dana',
        'penghasilan_tahunan',
        'penghasilan_tambahan_tahunan',
        'jml_setoran',
        'jml_tarikan',
        'maks_setor',
        'maks_tarik',
        'kode_dinas',
        'cncdbi',
        'cncdu6',
        'cnbi10',
        'cargcd',
        'cnxh03',
        'status',
        'status_time',
        'upload_user',
        'upload_time',
        'index_user',
        'index_time',
        'qc_user',
        'qc_time',
        'simpan_user',
        'simpan_time',
        'tanggal_lapor',
        'map'
    ];

    public function risiko()
    {
        switch ($this->risiko) {
            case '1':
                $return = "Aman";
                break;
            case '2':
                $return = "Sedang";
                break;
            case '3':
                $return = "Tinggi";
                break;
            default:
                $return = "Lainnya";
                break;
        }
        return $return;
    }
    public function golongan_nasabah()
    {
        switch ($this->golongan_nasabah) {
            case 'A':
                $return = "Pusat";
                break;
            case 'B':
                $return = "Daerah";
                break;
            case 'C':
                $return = "Badan / Lembaga Pemerintah";
                break;
            case 'D':
                $return = "BUMN";
                break;
            case 'E':
                $return = "BUMD";
                break;
            case 'F':
                $return = "Ass Swasta";
                break;
            case 'G':
                $return = "Intern";
                break;
            case 'H':
                $return = "Pembiayaan Swasta";
                break;
            case 'I':
                $return = "Individual";
                break;
            case 'J':
                $return = "Swasta Umum";
                break;
            case 'K':
                $return = "Dapen";
                break;
            case 'L':
                $return = "Blacklist";
                break;
            case 'M':
                $return = "Reksadana";
                break;
            case 'N':
                $return = "Yayasan  / Sosial / Ormas";
                break;
            case 'O':
                $return = "Pendidikan";
                break;
            case 'Q':
                $return = "Koperasi";
                break;
            case 'S':
                $return = "Asing";
                break;
            case 'T':
                $return = "Intern Bank";
                break;
            case 'U':
                $return = "Swasta Lain";
                break;
            case 'V':
                $return = "Impersonal";
                break;
            default:
                $return = "Lainnya";
                break;
        }
        return $return;
    }
    public function bi_gol_pajak()
    {
        switch ($this->bi_gol_pajak) {
            case '6':
                $return = "Individual tanpa NPWP";
                break;
            case '9':
                $return = "Individual dengan NPWP";
                break;
            default:
                $return = "Lainnya";
                break;
        }
        return $return;
    }
    public function bi_hub_bank()
    {
        switch ($this->bi_hub_bank) {
            case '1':
                $return = "TERKAIT DG BANK";
                break;
            case '2':
                $return = "TDK TERKAIT DG BANK";
                break;
            default:
                $return = "Lainnya";
                break;
        }
        return $return;
    }
    public function jenis_kelamin()
    {
        switch ($this->jenis_kelamin) {
            case 'L':
                $return = "Laki-laki";
                break;
            case 'P':
                $return = "Perempuan";
                break;
            default:
                $return = "Lainnya";
                break;
        }
        return $return;
    }
    public function kebangsaan()
    {
        switch ($this->kebangsaan) {
            case 'I':
                $return = "Indonesia";
                break;
            default:
                $return = "Lainnya";
                break;
        }
        return $return;
    }
    public function status_kawin()
    {
        switch ($this->status_kawin) {
            case 'B':
                $return = "Belum Kawin";
                break;
            case 'D':
                $return = "Cerai";
                break;
            case 'K':
                $return = "Kawin";
                break;
            default:
                $return = "Lainnya";
                break;
        }
        return $return;
    }
    public function agama()
    {
        switch ($this->agama) {
            case '1':
                $return = "Kristen";
                break;
            case '2':
                $return = "Hindu";
                break;
            case '3':
                $return = "Budha";
                break;
            case '4':
                $return = "Islam";
                break;
            case '5':
                $return = "Katholik";
                break;
            case '6':
                $return = "Konguchu";
                break;
            default:
                $return = "Lainnya";
                break;
        }
        return $return;
    }
    public function indexUser()
    {
        return $this->belongsTo(User::class, 'index_user');
    }

    public function qcUser()
    {
        return $this->belongsTo(User::class, 'qc_user');
    }

    public function uploadUser()
    {
        return $this->belongsTo(User::class, 'upload_user');
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'kelurahan_id');
    }
    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }
    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class, 'kabupaten_id');
    }
    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'provinsi_id');
    }
}
