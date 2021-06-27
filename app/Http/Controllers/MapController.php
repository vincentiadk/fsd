<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;

class MapController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Map Simpan',
            'content' => 'map',
        ];
        return view('layout.index', ['data' => $data]);
    }

    public function store()
    {
        $nasabah = Nasabah::where('no_rek', request('no_rek'))->first();
        if($nasabah){
            $nasabah->update([
                'map'   => request('map')
            ]);
        }
        return json()->response('success');
    }
}
