<?php

namespace App\Http\Controllers;

use App\Exports\NasabahExport;
use App\Models\Log;
use App\Models\Nasabah;
use App\Helper\Helper;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index()
    {
        if(session('role_id') != 1) {
            return abort(403);
        }
        $data = [
            'title' => 'Reporting',
            'content' => 'report',
            'logs'  => Helper::getLogs(session('id'))
        ];
        return view('layout.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $whereLike = [
            'id',
            'cif',
            'no_rek',
            'nama',
            'index_user',
            'index_time',
            'tanggal_lapor',
        ];

        $start = $request->input('start');
        $length = $request->input('length');
        $order = $whereLike[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $totalData = Nasabah::count();
        $filtered = $this->getFiltered($request);
        $totalFiltered = $filtered->count();
        $queryData = $filtered->offset($start)
            ->limit($length)
            ->orderBy($order, $dir)
            ->get();
        $response['data'] = [];
        if ($queryData != false) {
            foreach ($queryData as $val) {
                $index_time = $val->index_time != null ? date('d-m-Y', strtotime($val->index_time)) : '';
                $tanggal_lapor = $val->tanggal_lapor != null ? date('d-m-Y', strtotime($val->tanggal_lapor)) : '';
                $response['data'][] = [
                    '<input type="checkbox" id="chkReport_' . $val->id . '" name="chkReport" value="' . $val->id . '">
                     <a href="/admin/nasabah/'.$val->id.'/view" class="btn btn-primary"> Detail </a>
                    ',
                    $val->cif,
                    $val->no_rek,
                    $val->nama,
                    $val->indexUser ? $val->indexUser->name : "",
                    $val->uploadUser ? $val->uploadUser->name : "",
                    $val->status,
                    $index_time,
                    $tanggal_lapor,
                    $val->jenis_kelamin,
                    $val->no_identitas,
                    $val->npwp,
                    $val->status_kawin,
                    $val->agama,
                ];
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

    public function export(Request $request)
    {
        $data = $this->getFiltered($request);
        $filename = rand() . '_report.xlsx';
        Log::create([
            'user_id' => session('id'),
            'activity' => 'export',
            'description' => json_encode(['nama file' => $filename ]),
        ]);
        return Excel::download(new NasabahExport($data), $filename);
    }

    public function getFiltered($request)
    {
        $search = $request->input('search.value');
        $filtered = Nasabah::where(function ($query) use ($search) {
            $query->where('nama', 'like', "%{$search}%")
                ->orWhere('no_rek', 'like', "%{$search}%");
        });

        if (request('status_lapor') != '') {
            if (request('status_lapor') == '1') {
                $filtered->whereNotNull('tanggal_lapor');
                if (request('tanggal_lapor') != '') {
                    $filtered->whereDate('tanggal_lapor', '>=', request('tanggal_lapor'));
                }
                if (request('tanggal_lapor_akhir') != '') {
                    $filtered->whereDate('tanggal_lapor', '<=', request('tanggal_lapor_akhir'));
                }
            }
            if (request('status_lapor') == '0') {
                $filtered->whereNull('tanggal_lapor')
                    ->where('status', 'benar');
            }
        }
        if (request('status') != '') {
            $filtered->whereIn('status', request('status'));
        }
        return $filtered;
    }

    public function setTanggalLapor(Request $request)
    {
        if (request('ids') == '') {
            return response()->json('Tidak ada nasabah yang dipilih.');
        }
        $check = Nasabah::whereIn('id', request('ids'))
            ->whereNotIn('status', ['benar', 'tuntas'])
            ->count();
        if ($check > 1) {
            $return = 'Selain status benar dan tuntas, tanggal lapor tidak dapat diset.';
        } else {
            $return = 'Sukses set tanggal lapor.';
        }
        Nasabah::whereIn('id', request('ids'))
            ->whereIn('status', ['benar', 'tuntas'])
            ->update([
                'tanggal_lapor' => request('set_lapor'),
                'status' => 'tuntas',
            ]);
        return response()->json($return);
    }
}
