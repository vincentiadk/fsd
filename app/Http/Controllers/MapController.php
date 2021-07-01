<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\Nasabah;

class MapController extends Controller
{
    public function index()
    {
        if((!in_array('map', json_decode(session('permissions')))) && !(session('role_id') == 1) ){
            return abort(403);
        }
        $data = [
            'title' => 'Map Simpan',
            'content' => 'map',
            'logs' => Helper::getLogs(session('id')),
            'nasabah' => Nasabah::whereNull('map')
                ->whereNotIn('status', ['kosong'])
                ->get(),
        ];
        return view('layout.index', ['data' => $data]);
    }

    public function store()
    {
        $nasabah = Nasabah::whereIn('no_rek', request('no_rek'))
        ->update([
                'map' => request('map'),
            ]);
        
        $response = [
            'status' => 200,
            'message' => 'Berhasil menyimpan',
        ];
        return response()->json($response);
    }
}