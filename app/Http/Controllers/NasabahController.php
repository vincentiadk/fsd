<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use App\Models\Log;

class NasabahController extends Controller
{
    public function indexing()
    {
        $nasabah_salah = Nasabah::where('status', 'salah')
            ->where('index_user', session('id'))
            ->first();

        $data = [
            'title' => 'Indexing Data Nasabah',
            'content' => 'indexing',
            'file' => '',
        ];

        if ($nasabah_salah) {
            $data['nasabah'] = $nasabah_salah;
        } else {
            $nasabah_index = Nasabah::where('status', 'indexing')
                ->where('index_user', session('id'))
                ->first();
            if ($nasabah_index) {
                $data['nasabah'] = $nasabah_index;
                $data['file'] = url("nasabah/$nasabah_index->no_rek" . ".pdf");
            } else {
                $nasabah_baru = Nasabah::where('status', 'baru')
                    ->first();
                if ($nasabah_baru) {
                    $nasabah_baru->update([
                        'index_user' => session('id'),
                        'index_time' => now(),
                        'status' => 'indexing',
                        'status_time' => now(),
                    ]);
                    Log::create([
                        'user_id'   => session('id'),
                        'activity'  => 'mulai indexing',
                        'description'   => 'baru -> indexing'
                    ]);
                    $data['nasabah'] = $nasabah_baru;
                    $data['file'] = public_path("nasabah/$nasabah_baru->no_rek" . ".pdf");
                } else {
                    $data['nasabah'] = [];
                }
            }
        }

        return view('layout.index', ['data' => $data]);
    }

    public function qc()
    {
        $nasabah_qc = Nasabah::where('status', 'qc')
            ->where('qc_user', session('id'))
            ->first();

        $data = [
            'title' => 'Indexing Data Nasabah',
            'content' => 'indexing',
            'file' => '',
        ];
        if ($nasabah_qc) {
            $data['nasabah'] = $nasabah_qc;
            $data['file'] = url("nasabah/$nasabah_qc->no_rek" . ".pdf");
        } else {
            $nasabah_update = Nasabah::where('status', 'update')
                ->where('qc_user', session('id'))
                ->first();
            if ($nasabah_update) {
                $data['nasabah'] = $nasabah_update;
                $data['file'] = url("nasabah/$nasabah_update->no_rek" . ".pdf");
            } else {
                $nasabah_update_new = Nasabah::where('status', 'update')
                    ->whereNull('qc_user')
                    ->first();
                if ($nasabah_update_new) {
                    $nasabah_update_new->update([
                        'qc_user' => session('id'),
                        'qc_time' => now(),
                        'status' => 'qc',
                        'status_time' => now(),
                    ]);
                    Log::create([
                        'user_id'   => session('id'),
                        'activity'  => 'mulai qc',
                        'description'   => 'update -> qc'
                    ]);
                    $data['nasabah'] = $nasabah_update_new;
                    $data['file'] = url("nasabah/$nasabah_update_new->no_rek" . ".pdf");
                } else {
                    $data['nasabah'] = [];
                }
            }
        }
        return view('layout.index', ['data' => $data]);
    }

    public function store()
    {
        $id = request('id_nasabah');
        $nasabah = Nasabah::find($id);

        if (session('role_id') == 4) {
            $nasabah->update([
                'status' => strtolower(request('submit')),
            ]);
            Log::create([
                'user_id'   => session('id'),
                'activity'  => 'selesai qc',
                'description' => 'update -> ' . strtolower(request('submit'))
            ]);
            return redirect('admin/nasabah/qc');
        }

        if(session('role_id') == 3) {
            $nasabah->update([
                'nama'          => request('nama'),
                'no_identitas'  => request('no_identitas'),
                'kelurahan'     => request('kelurahan'),
                'kecamatan'     => request('kecamatan'),
                'provinsi'      => request('provinsi'),
                'kabupaten'     => request('kabupaten'),
                'alamat_1'      => request('alamat_1'),
                'telp_hp'       => request('telp_hp'),
                'nama_ibu_kandung' => request('nama_ibu_kandung'),
                'rt'            => request('rt'),
                'rw'            => request('rw'),
                'email'         => request('email'),
                'status'        => 'update',
                'index_time'    => now(),
                'status_time'   => now(),
            ]);
            Log::create([
                'user_id'   => session('id'),
                'activity'  => 'selesai indexing',
                'description' => 'indexing -> update'
            ]);
            return redirect('admin/nasabah/indexing');
        }
    }

    public function view($id)
    {
        $data = [
            'title' => 'Lihat Data Nasabah',
            'content' => 'indexing',
            'file' => '',
        ];
        $nasabah = Nasabah::find($id);
        $data['nasabah'] = $nasabah;
        $data['file'] = url("nasabah/$nasabah->no_rek" . ".pdf");

        return view('layout.index', ['data' => $data]);
    }
}
