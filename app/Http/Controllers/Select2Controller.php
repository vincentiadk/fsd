<?php

namespace App\Http\Controllers;

use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Nasabah;
use App\Models\Provinsi;
use Illuminate\Http\Request;

class Select2Controller extends Controller
{
    public function getProvinsi()
    {
        $data = Provinsi::where('name', 'LIKE', '%' . request('search') . '%')->get();
        $response[] = [
            'id' => '',
            'text' => 'Semua Provinsi',
        ];

        foreach ($data as $d) {
            $response[] = [
                'id' => $d->id,
                'text' => $d->name,
            ];
        }

        return response()->json(['items' => $response]);
    }

    public function getKabupaten()
    {
        $id = request('sourcepoint');

        if ($id != "") {
            $id_ = Provinsi::find($id)->code;
            $data = Kabupaten::where('name', 'LIKE', '%' . request('search') . '%')
                ->where('provinsi_id', $id_)
                ->get();
        } else {
            $data = Kabupaten::where('name', 'LIKE', '%' . request('search') . '%')
                ->get();
        }

        $response[] = [
            'id' => '',
            'text' => 'Semua Provinsi',
        ];

        foreach ($data as $d) {
            $response[] = [
                'id' => $d->id,
                'text' => $d->name,
            ];
        }

        return response()->json(['items' => $response]);
    }

    public function getKecamatan()
    {
        $id = request('sourcepoint');
        if ($id != "") {
            $id_ = Kabupaten::find($id)->code;
            $data = Kecamatan::where('name', 'LIKE', '%' . request('search') . '%')
                ->where('kabupaten_id', $id_)
                ->get();
        } else {
            $data = Kecamatan::where('name', 'LIKE', '%' . request('search') . '%')
                ->get();
        }
        $response[] = [
            'id' => '',
            'text' => 'Semua Provinsi',
        ];

        foreach ($data as $d) {
            $response[] = [
                'id' => $d->id,
                'text' => $d->name,
            ];
        }

        return response()->json(['items' => $response]);
    }

    public function getKelurahan()
    {
        $id = request('sourcepoint');
        if ($id != "") {
            $id_ = Kecamatan::find($id)->code;
            $data = Kelurahan::where('name', 'LIKE', '%' . request('search') . '%')
                ->where('kecamatan_id', $id_)
                ->get();
        } else {
            $data = Kelurahan::where('name', 'LIKE', '%' . request('search') . '%')
                ->get();
        }

        $response[] = [
            'id' => '',
            'text' => 'Semua Provinsi',
        ];

        foreach ($data as $d) {
            $response[] = [
                'id' => $d->id,
                'text' => $d->name,
            ];
        }

        return response()->json(['items' => $response]);
    }

    public function getMap()
    {
        return Nasabah::where('map', request('map'))
            ->orderBy('no_rek', 'asc')
            ->get();
    }
}
