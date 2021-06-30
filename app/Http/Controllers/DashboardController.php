<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\Nasabah;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        switch (session('role_id')) {
            case 1:
                $data = [
                    'title' => 'Dashboard Manager',
                    'content' => 'dashboard-manager',
                ];
                break;
            case 2:
                $data = [
                    'title' => 'Dashboard Operator Upload',
                    'content' => 'dashboard-upload',
                ];
                break;
            case 3:
                $data = [
                    'title' => 'Dashboard Operator Index',
                    'content' => 'dashboard-index',
                ];
                break;
            case 4:
                $data = [
                    'title' => 'Dashboard Supervisor',
                    'content' => 'dashboard-supervisor',
                ];
                break;
            case 5:
                $data = [
                    'title' => 'Dashboard Client',
                    'content' => 'dashboard-client',
                ];
                break;
            default:
                $data = [
                    'title' => 'Dashboard Client',
                    'content' => 'dashboard-client',
                ];
                break;
        }
        $data['logs'] = Helper::getLogs(session('id'));

        return view('layout.index', ['data' => $data]);
    }

    public function datatableRealtime(Request $request)
    {
        $whereLike = [
            'id',
            'created_at',
            'index_time',
            'id',
            'created_at',
            'index_time',
        ];

        $start = $request->input('start');
        $length = $request->input('length');
        $order = $whereLike[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');

        $filtered = Nasabah::selectRaw("COUNT(*) id, DATE_FORMAT(status_time, '%Y-%m-%d') as period")
            ->whereNotNull('status_time')
            ->groupBy(\DB::raw("DATE_FORMAT(status_time, '%Y-%m-%d')"));
        $totalData = $filtered->count();

        $queryData = $filtered->offset($start)
            ->limit($length)
            ->orderBy($order, $dir)
            ->get();

        $response['data'] = [];
        foreach ($queryData as $val) {
            $date = $val->period;
            $response['data'][] = [
                $val->period,
                Nasabah::where(function ($query) use ($date) {
                    $query->where('status', 'update')
                        ->orWhere('status', 'indexing');
                })->whereDate('index_time', $date)->count(),
                Nasabah::where('status', 'benar')->whereDate('index_time', $date)->count(),
                Nasabah::where('status', 'salah')->whereDate('index_time', $date)->count(),
                Nasabah::where('status', 'tolak')->whereDate('index_time', $date)->count(),
                Nasabah::where('status', 'baru')->whereDate('status_time', $date)->count(),
            ];
        }
        $response['recordsTotal'] = 0;
        if ($totalData != false) {
            $response['recordsTotal'] = $totalData;
        }

        $response['recordsFiltered'] = 0;
        if ($totalData != false) {
            $response['recordsFiltered'] = $totalData;
        }

        return response()->json($response);
    }

    public function datatableTuntas(Request $request)
    {
        $whereLike = [
            'id',
            'created_at',
        ];

        $start = $request->input('start');
        $length = $request->input('length');
        $order = $whereLike[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');

        $filtered = Nasabah::selectRaw("COUNT(*) id, DATE_FORMAT(tanggal_lapor, '%Y-%m-%d') as period")
            ->whereNotNull('tanggal_lapor')
            ->where('status', 'tuntas')
            ->groupBy(\DB::raw("DATE_FORMAT(tanggal_lapor, '%Y-%m-%d')"));

        $totalData = $filtered->count();
        $queryData = $filtered->offset($start)
            ->limit($length)
            ->orderBy($order, $dir)
            ->get();

        $response['data'] = [];
        foreach ($queryData as $val) {
            $date = $val->period;
            $response['data'][] = [
                $date,
                Nasabah::where('status', 'tuntas')->whereDate('tanggal_lapor', $date)->count(),
            ];
        }

        $response['recordsTotal'] = 0;
        if ($totalData != false) {
            $response['recordsTotal'] = $totalData;
        }

        $response['recordsFiltered'] = 0;
        //if($totalFiltered <> FALSE) {
        $response['recordsFiltered'] = $totalData;
        //}

        return response()->json($response);
    }

    public function datatableUpload(Request $request)
    {
        $whereLike = [
            'id',
            'created_at',
        ];

        $start = $request->input('start');
        $length = $request->input('length');
        $order = $whereLike[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');

        $filtered = Nasabah::selectRaw("COUNT(*) id, DATE_FORMAT(upload_time, '%Y-%m-%d') as period")
            ->whereNotNull('upload_time')
            ->where('upload_user', session('id'))
            ->groupBy(\DB::raw("DATE_FORMAT(upload_time, '%Y-%m-%d')"));

        $totalData = $filtered->count();

        $queryData = $filtered->offset($start)
            ->limit($length)
            ->orderBy($order, $dir)
            ->get();

        $response['data'] = [];
        foreach ($queryData as $val) {
            $date = $val->period;
            $response['data'][] = [
                $date,
                Nasabah::where('upload_user', session('id'))->whereDate('upload_time', $date)->count(),
            ];
        }

        $response['recordsTotal'] = 0;
        if ($totalData != false) {
            $response['recordsTotal'] = $totalData;
        }

        $response['recordsFiltered'] = 0;
        //if($totalFiltered <> FALSE) {
        $response['recordsFiltered'] = $totalData;
        //}

        return response()->json($response);
    }
}
