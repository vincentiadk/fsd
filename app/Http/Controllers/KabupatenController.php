<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\Kabupaten;
use Illuminate\Http\Request;

class KabupatenController extends Controller
{
    public function index()
    {
        if( (!in_array('kabupaten', json_decode(session('permissions')))) && (!session('role_id') == 1)) {
            return abort(403);
        }
        $data = [
            'title' => 'Daftar Seluruh Kabupaten / Kota',
            'content' => 'kabupaten',
            'logs' => Helper::getLogs(session('id')),
        ];
        return view('layout.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $whereLike = [
            'id',
            'code',
            'provinsi_id',
            'name',
            'latitude',
            'longitude',
        ];

        $start = $request->input('start');
        $length = $request->input('length');
        $order = $whereLike[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');
        $totalData = Kabupaten::count();

        $filtered = Kabupaten::where(function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('latitude', 'like', "%{$search}%")
                ->orWhere('code', 'like', "%{$search}%")
                ->orWhere('longitude', 'like', "%{$search}%")
                ->orWhereHas('provinsi', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                });
        });

        $totalFiltered = $filtered->count();
        $queryData = $filtered->offset($start)
            ->limit($length)
            ->orderBy($order, $dir)
            ->get();
        $response['data'] = [];
        if ($queryData != false) {
            $nomor = $start + 1;
            foreach ($queryData as $val) {
                $response['data'][] = [
                    $nomor,
                    $val->code,
                    $val->provinsi ? $val->provinsi->name : "",
                    $val->name,
                    $val->latitude,
                    $val->longitude,
                ];
                $nomor++;
            }
        }
        $response['recordsTotal'] = 0;
        if ($totalData != false) {
            $response['recordsTotal'] = $totalData;
        }

        $response['recordsFiltered'] = 0;
        if ($totalFiltered != false) {
            $response['recordsFiltered'] = $totalFiltered;
        }
        return response()->json($response);
    }
}
