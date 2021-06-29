<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNasabahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
        Schema::create('nasabah', function (Blueprint $table) {
            $table->id();
            $table->char('cif', 15)->nullable();
            $table->string('no_rek', 11)->unique();
            $table->char('cab', 5)->nullable();
            $table->string('status_rek');
            $table->char('risiko', 1);
            $table->char('tgl_buka', 8);
            $table->char('golongan_nasabah', 1);
            $table->char('bi_gol_pajak', 1);
            $table->char('bi_hub_bank', 1);
            $table->string('nama', 40);
            $table->char('jenis_kelamin', 1);
            $table->char('kebangsaan', 1);
            $table->string('tempat_lahir', 29)->nullable();
            $table->char('tgl_lahir', 8);
            $table->string('no_identitas', 20);
            $table->char('masa_berlaku_identitas', 8);
            $table->char('npwp', 15);
            $table->string('nama_ibu_kandung', 25);
            $table->char('status_kawin', 1);
            $table->char('agama', 1);
            $table->char('pendidikan', 3);
            $table->string('alamat_1');
            $table->string('alamat_2');
            $table->char('rt', 5);
            $table->char('rw', 5);
            $table->foreignId('provinsi_id')->nullable()->constrained('provinsi');
            $table->foreignId('kabupaten_id')->nullable()->constrained('kabupaten');
            $table->foreignId('kecamatan_id')->nullable()->constrained('kecamatan');
            $table->foreignId('kelurahan_id')->nullable()->constrained('kelurahan');
            $table->string('kodepos');
            $table->char('status_rumah', 1);
            $table->char('telp_hp', 14);
            $table->char('telp_rumah', 14);
            $table->char('alamat_surat', 1);
            $table->char('tipe_alamat', 1);
            $table->char('pekerjaan', 1);
            $table->char('kode_profesi', 2);
            $table->char('status_pekerjaan', 1);
            $table->string('nama_instansi', 40);
            $table->string('alamat_instansi');
            $table->string('kodepos_instansi', 5);
            $table->string('telp_instansi', 14);
            $table->string('suami_istri', 40);
            $table->string('nama_kontak_darurat', 40);
            $table->char('hubungan_darurat', 1);
            $table->string('alamat_darurat');
            $table->foreignId('darurat_provinsi_id')->nullable()->constrained('provinsi');
            $table->foreignId('darurat_kabupaten_id')->nullable()->constrained('kabupaten');
            $table->string('telp_darurat', 14);
            $table->char('sumber_dana', 1);
            $table->char('tujuan_penggunaan_dana', 1);
            $table->char('penghasilan_tahunan', 1);
            $table->char('penghasilan_tambahan_tahunan', 1);
            $table->char('jml_setoran', 1);
            $table->char('jml_tarikan', 1);
            $table->integer('maks_setor');
            $table->integer('maks_tarik');
            $table->char('kode_dinas', 6);
            $table->char('cncdbi', 5)->comments('BI Status Penduduk');
            $table->char('cncdu6', 3)->comments('Internal rating nasabah');
            $table->char('cnbi10', 3)->comments('Gelar perorangan');
            $table->char('cargcd', 4)->comments('Kode Dati II');
            $table->char('cnxh03', 5)->comments('BI Lembaga pemerintah');
            $table->char('status', 10)->default('kosong');
            $table->timestamp('status_time')->nullable();
            $table->foreignId('upload_user')->nullable()->constrained('users');
            $table->timestamp('upload_time')->nullable();
            $table->foreignId('index_user')->nullable()->constrained('users');
            $table->timestamp('index_time')->nullable();
            $table->foreignId('qc_user')->nullable()->constrained('users');
            $table->timestamp('qc_time')->nullable();
            $table->foreignId('simpan_user')->nullable()->constrained('users');
            $table->timestamp('simpan_time')->nullable();
            $table->timestamp('tanggal_lapor')->nullable();
            $table->string('map')->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamps();
        });
        */
        Schema::create('nasabah', function (Blueprint $table) {
            $table->id();
            $table->char('cif', 15)->nullable();
            $table->string('no_rek', 11)->unique();
            $table->char('cab', 5)->nullable();
            $table->string('status_rek')->nullable();
            $table->string('risiko')->nullable();
            $table->char('tgl_buka', 8)->nullable();
            $table->string('golongan_nasabah')->nullable();
            $table->string('bi_gol_pajak')->nullable();
            $table->string('bi_hub_bank')->nullable();
            $table->string('nama', 40);
            $table->string('jenis_kelamin')->nullable();
            $table->string('kebangsaan')->nullable();
            $table->string('tempat_lahir', 29)->nullable();
            $table->string('tgl_lahir', 8)->nullable();
            $table->string('no_identitas', 20)->nullable();
            $table->char('masa_berlaku_identitas', 8)->nullable();
            $table->char('npwp', 15)->nullable();
            $table->string('nama_ibu_kandung', 25)->nullable();
            $table->string('status_kawin')->nullable();
            $table->string('agama')->nullable();
            $table->string('pendidikan')->nullable();
            $table->string('alamat_1')->nullable();
            $table->string('alamat_2')->nullable();
            $table->char('rt', 5)->nullable();
            $table->char('rw', 5)->nullable();
            $table->foreignId('provinsi_id')->nullable()->constrained('provinsi');
            $table->foreignId('kabupaten_id')->nullable()->constrained('kabupaten');
            $table->foreignId('kecamatan_id')->nullable()->constrained('kecamatan');
            $table->foreignId('kelurahan_id')->nullable()->constrained('kelurahan');
            $table->string('kodepos', 10)->nullable();
            $table->string('status_rumah')->nullable();
            $table->char('telp_hp', 14)->nullable();
            $table->char('telp_rumah', 14)->nullable();
            $table->string('alamat_surat')->nullable();
            $table->string('tipe_alamat')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('kode_profesi')->nullable();
            $table->string('status_pekerjaan')->nullable();
            $table->string('nama_instansi', 40)->nullable();
            $table->string('alamat_instansi')->nullable();
            $table->string('kodepos_instansi', 5)->nullable();
            $table->string('telp_instansi', 14)->nullable();
            $table->string('suami_istri', 40)->nullable();
            $table->string('nama_kontak_darurat', 40)->nullable();
            $table->string('hubungan_darurat')->nullable();
            $table->string('alamat_darurat')->nullable();
            $table->foreignId('darurat_provinsi_id')->nullable()->constrained('provinsi');
            $table->foreignId('darurat_kabupaten_id')->nullable()->constrained('kabupaten');
            $table->string('telp_darurat', 14)->nullable();
            $table->string('sumber_dana')->nullable();
            $table->string('tujuan_penggunaan_dana')->nullable();
            $table->string('penghasilan_tahunan')->nullable();
            $table->string('penghasilan_tambahan_tahunan')->nullable();
            $table->string('jml_setoran')->nullable();
            $table->string('jml_tarikan')->nullable();
            $table->integer('maks_setor')->nullable();
            $table->integer('maks_tarik')->nullable();
            $table->string('kode_dinas', 6)->nullable();
            $table->string('cncdbi')->nullable()->comments('BI Status Penduduk');
            $table->string('cncdu6')->nullable()->comments('Internal rating nasabah');
            $table->string('cnbi10')->nullable()->comments('Gelar perorangan');
            $table->string('cargcd')->nullable()->comments('Kode Dati II');
            $table->string('cnxh03')->nullable()->comments('BI Lembaga pemerintah');
            $table->char('status', 10)->default('kosong');
            $table->timestamp('status_time')->nullable();
            $table->foreignId('upload_user')->nullable()->constrained('users');
            $table->timestamp('upload_time')->nullable();
            $table->foreignId('index_user')->nullable()->constrained('users');
            $table->timestamp('index_time')->nullable();
            $table->foreignId('qc_user')->nullable()->constrained('users');
            $table->timestamp('qc_time')->nullable();
            $table->foreignId('simpan_user')->nullable()->constrained('users');
            $table->timestamp('simpan_time')->nullable();
            $table->timestamp('tanggal_lapor')->nullable();
            $table->string('map')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('nama_file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('costumers');
    }
}
