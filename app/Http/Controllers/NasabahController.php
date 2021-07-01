<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\Nasabah;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class NasabahController extends Controller
{
    public function indexing()
    {
        if( !in_array('indexing', json_decode(session('permissions'))) && !(session('role_id') == 1)) {
            return abort(403);
        }
        $nasabah_salah = Nasabah::where('status', 'salah')
            ->where('index_user', session('id'))
            ->first();

        $data = [
            'title' => 'Indexing Data Nasabah',
            'content' => 'indexing',
            'file' => '',
            'logs' => Helper::getLogs(session('id')),
        ];

        if ($nasabah_salah) {
            $data['nasabah'] = $nasabah_salah;
            $data['file'] = $nasabah_salah->nama_file;
        } else {
            $nasabah_index = Nasabah::where('status', 'indexing')
                ->where('index_user', session('id'))
                ->first();
            if ($nasabah_index) {
                $data['nasabah'] = $nasabah_index;
                $data['file'] = $nasabah_index->nama_file != "" ? "true" : "";
            } else {
                $nasabah_baru = Nasabah::where('status', 'baru')
                    ->first();
                if ($nasabah_baru) {
                    if( ! session('role_id') == 1) {
                        $nasabah_baru->update([
                            'index_user' => session('id'),
                            'index_time' => now(),
                            'status' => 'indexing',
                            'status_time' => now(),
                        ]);
                    }
                    $data['nasabah'] = $nasabah_baru;
                    $data['file'] = $nasabah_baru->nama_file != "" ? "true" : '';
                } else {
                    $data['nasabah'] = [];
                }
            }
        }

        return view('layout.index', ['data' => $data]);
    }

    public function qc()
    {
        if( !in_array('qc', json_decode(session('permissions'))) && !(session('role_id') == 1) ) {
            return abort(403);
        }
        $nasabah_qc = Nasabah::where('status', 'qc')
            ->where('qc_user', session('id'))
            ->first();

        $data = [
            'title' => 'Indexing Data Nasabah',
            'content' => 'indexing',
            'file' => '',
            'logs' => Helper::getLogs(session('id')),
        ];
        if ($nasabah_qc) {
            $data['nasabah'] = $nasabah_qc;
            $data['file'] = $nasabah_qc->nama_file != "" ? "true" : "";
        } else {
            $nasabah_update = Nasabah::where('status', 'update')
                ->where('qc_user', session('id'))
                ->first();
            if ($nasabah_update) {
                $data['nasabah'] = $nasabah_update;
                $data['file'] = $nasabah_update->nama_file != "" ? "true" : "";
            } else {
                $nasabah_update_new = Nasabah::where('status', 'update')
                    ->whereNull('qc_user')
                    ->first();
                if ($nasabah_update_new) {
                    if( ! session('role_id') == 1) {
                        $nasabah_update_new->update([
                            'qc_user' => session('id'),
                            'qc_time' => now(),
                            'status' => 'qc',
                            'status_time' => now(),
                        ]);
                    }
                    $data['nasabah'] = $nasabah_update_new;
                    $data['file'] = $nasabah_update_new->nama_file != "" ? "true" : "";
                } else {
                    $data['nasabah'] = [];
                }
            }
        }
        return view('layout.index', ['data' => $data]);
    }

    public function store()
    {
        if( session('role_id') == 1) {
            return abort(403);
        }
        $id = request('id_nasabah');
        $nasabah = Nasabah::findOrFail($id);

        if(!in_array('qc-simpan', json_decode(session('permissions')))) {
            $nasabah->update([
                'status' => request('status'),
                'index_time' => now(),
            ]);
            $response = [
                'status' => 200,
                'message' => 'Berhasil menyimpan',
                'page' => 'qc',
            ];
        }

        if(!in_array('indexing-simpan', json_decode(session('permissions')))) {
            Validator::extend('without_spaces', function ($attr, $value) {
                return preg_match('/^\S*$/u', $value);
            });
            Validator::extend('without_spaces', function ($attr, $value) {
                return preg_match('/^\S*$/u', $value);
            });
            Validator::extend('number', function ($attr, $value) {
                return preg_match('/^[0-9]+$/', $value);
            });
            Validator::extend(
                'telp', function ($attr, $value) {
                    if (substr($value, 0, 2) === "62") {
                        return true;
                    } else {
                        return false;
                    }
                });
            Validator::extend(
                'cif', function ($attr, $value) {
                    if (substr($value, 0, 3) === "000") {
                        return true;
                    } else {
                        return false;
                    }
                });

            $validator = Validator::make(request()->all(), [
                'nama' => 'required|min:5',
                'no_identitas' => 'required|without_spaces|min:16|number',
                'email' => 'required|email|unique:nasabah,email,' . $id . '',
                'provinsi_id' => 'required',
                'kabupaten_id' => 'required',
                'kecamatan_id' => 'required',
                'kelurahan_id' => 'required',
                'nama_ibu_kandung' => 'required',
                'telp_hp' => 'required|telp|number',
                'alamat_1' => 'required',
            ], [
                'nama.required' => 'Nama nasabah wajib diisi! ',
                'nama.min' => 'Nama nasabah minimal 5 huruf! ',
                'no_identitas.without_spaces' => 'Nomor KTP/identitas tidak boleh menggunakan spasi! ',
                'no_identitas.min' => 'Nomor KTP/identitas minimal 16 digit! ',
                'no_identitas.number' => 'Nomor KTP/identitas hanya boleh berisi angka! ',
                'email.required' => 'Email wajib diisi! ',
                'email.unique' => 'Email telah terdaftar! ',
                'email.email' => 'Format email salah! ',
                'provinsi_id.required' => 'Provinsi wajib diisi! ',
                'kabupaten_id.required' => 'Kabupaten / Kota wajib diisi! ',
                'kecamatan_id.required' => 'Kecamatan wajib diisi! ',
                'kelurahan_id.required' => 'Kelurahan wajib diisi! ',
                'nama_ibu_kandung.required' => 'Nama ibu kandung wajib diisi! ',
                'telp_hp.required' => 'Nomor telepon handphone wajib diisi! ',
                'telp_hp.telp' => 'Nomor telepon handphone harus dimulai dari angka 62! ',
                'telp_hp.number' => 'Nomor telepon handphone hanya boleh berisi angka! ',
                'alamat_1.required' => 'Alamat wajib diisi! ',
            ]);

            if ($validator->fails()) {
                $response = [
                    'status' => 422,
                    'error' => $validator->errors(),
                ];
            } else {
                $nasabah->update([
                    'nama' => request('nama'),
                    'no_identitas' => request('no_identitas'),
                    'kelurahan_id' => request('kelurahan_id'),
                    'kecamatan_id' => request('kecamatan_id'),
                    'provinsi_id' => request('provinsi_id'),
                    'kabupaten_id' => request('kabupaten_id'),
                    'alamat_1' => request('alamat_1'),
                    'telp_hp' => request('telp_hp'),
                    'nama_ibu_kandung' => request('nama_ibu_kandung'),
                    'rt' => request('rt'),
                    'rw' => request('rw'),
                    'email' => request('email'),
                    'status' => 'update',
                    'index_time' => now(),
                    'status_time' => now(),
                ]);
                $response = [
                    'status' => 200,
                    'message' => 'Berhasil menyimpan',
                    'page' => 'indexing',
                ];
            }

        }
        return response()->json($response);
    }

    public function view($id)
    {
        if((!in_array('view-nasabah', json_decod(session('permissions')))) && (!session('role_id') == 1)) {
            return abort(403);
        }
        $data = [
            'title' => 'Lihat Data Nasabah',
            'content' => 'indexing',
            'file' => '',
            'logs' => Helper::getLogs(session('id')),
        ];
        $nasabah = Nasabah::findOrFail($id);
        $data['nasabah'] = $nasabah;

        if (File::exists(\Storage::path('nasabah/' . $nasabah->nama_file))) {
            $data['file'] = $nasabah->nama_file;
        }

        return view('layout.index', ['data' => $data]);
    }

    public function streamPdf()
    {
        $data = Nasabah::where('nama_file', request('id'))->first();
        if ($data) {
            return response()->download(\Storage::path('nasabah/' . $data->nama_file), null, [
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0',
            ], null);
        } else {
            return abort(404);
        }
    }
}
