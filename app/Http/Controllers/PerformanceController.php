<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\ExportToView;
use App\Helper\Helper;
use App\Models\User;
use App\Models\NasabahStatusIndex;
use App\Models\Log;
use Maatwebsite\Excel\Facades\Excel;

class PerformanceController extends Controller
{
    public function index()
    {
        if((!in_array('performance', json_decode(session('permissions'))))  && !(session('role_id') == 1)) {
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
            'name',
            'latitude',
            'longitude',
            'name',
        ];

        $start = $request->input('start');
        $length = $request->input('length');
        $order = $whereLike[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $totalData = User::count();

        $filtered = $this->getFiltered($request);
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
                    $val->role->name,
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

    public function getFiltered($request)
    {
        $search = $request->input('search.value');

        $filtered = User::where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%");
            });
        return $filtered;
    }

    public function export(Request $request)
    {
        if((!in_array('export-performance', json_decode(session('permissions')))) && !(session('role_id') == 1)){
            return abort(403);
        }
        $data['data'] = $this->getFiltered($request);
        $data['view'] = 'export-performance';
        $filename = rand() . '_performance-report.xlsx';
        Log::create([
            'user_id' => session('id'),
            'activity' => 'export performance',
            'description' => json_encode(['nama file' => $filename ]),
        ]);
        return Excel::download(new ExportToView($data), $filename);
    }

}
