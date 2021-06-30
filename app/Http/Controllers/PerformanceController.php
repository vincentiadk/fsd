<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper\Helper;
use App\Models\User;
use App\Models\NasabahStatusIndex;

class PerformanceController extends Controller
{
    public function index()
    {
        if (session('role_id') != 1) {
            return abort(403);
        }
        $data = [
            'title' => 'Kinerja User',
            'content' => 'performance',
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
        $totalData = User::count();

        $filtered = User::where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%");
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
                $benar =  NasabahStatusIndex::where('status', 'benar')
                    ->where('user_id',$val->id)
                    ->count();
                $salah =  NasabahStatusIndex::where('status', 'salah')
                    ->where('user_id',$val->id)
                    ->count();
                $tolak =  NasabahStatusIndex::where('status', 'tolak')
                    ->where('user_id',$val->id)
                    ->count();
                $tuntas =  NasabahStatusIndex::where('status', 'tuntas')
                    ->where('user_id',$val->id)
                    ->count();
                $upload =  NasabahStatusIndex::where('status', 'baru')
                    ->where('user_id',$val->id)
                    ->count();
                $qc =  NasabahStatusIndex::where('status', 'qc')
                    ->where('user_id',$val->id)
                    ->count();
                $indexing =  NasabahStatusIndex::where('status', 'indexing')
                    ->where('user_id',$val->id)
                    ->count();
                $response['data'][] = [
                    $nomor,
                    $val->name,
                    $val->role(),
                    $upload,
                    $benar,
                    $salah,
                    $tolak,
                    $qc,
                    $indexing,
                    $tuntas
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
