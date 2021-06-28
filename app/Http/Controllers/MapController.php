<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\Nasabah;

class MapController extends Controller
{
    public function index()
    {
        if(session('role_id') != 1 && session('role_id') != 2) {
            return abort(403);
        }
        $data = [
            'title' => 'Map Simpan',
            'content' => 'map',
            'logs' => Helper::getLogs(session('id')),
            'nasabah' => Nasabah::whereNull('map')
                ->where('upload_user', session('id'))
                ->get(),
        ];
        return view('layout.index', ['data' => $data]);
    }

    public function store()
    {
        $nasabah = Nasabah::where('no_rek', request('no_rek'))->first();
        if ($nasabah) {
            $nasabah->update([
                'map' => request('map'),
            ]);
        }
        return json()->response('success');
    }
}
