<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;
use App\Helper\Helper;

class LogController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Log Aktifitas',
            'content' => 'log',
            'logs'  => Helper::getLogs(session('id'))
        ];
        return view('layout.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $whereLike = [
            'id',
            'user_id',
            'activity',
            'description',
            'created_at',
        ];

        $start = $request->input('start');
        $length = $request->input('length');
        $order = $whereLike[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');
        $totalData = Log::count();

        $filtered = Log::where(function ($query) use ($search) {
            $query->where('activity', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhere('logable_type', 'like', "%{$search}%");
        });
        if(session('role_id') != 1) {
            $filtered->where('user_id', session('id'));
        }
        $totalFiltered = $filtered->count();
        $queryData = $filtered->offset($start)
            ->limit($length)
            ->orderBy($order, $dir)
            ->get();
        $response['data'] = [];
        if ($queryData <> false) {
            $nomor = $start + 1;
            foreach ($queryData as $val) {
                $response['data'][] = [
                    $nomor,
                    $val->user->name,
                    $val->activity,
                    $val->description(),
                    $val->created_at,
                ];
                $nomor ++;
            }
        }
        $response['recordsTotal'] = 0;
        if ($totalData <> false) {
            $response['recordsTotal'] = $totalData;
        }

        $response['recordsFiltered'] = 0;
        if ($totalFiltered <> false) {
            $response['recordsFiltered'] = $totalFiltered;
        }
        return response()->json($response);
    }
}
