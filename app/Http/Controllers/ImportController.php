<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Imports\NasabahImport;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function index()
    {
        if( (!in_array('import', json_decode(session('permissions')))) && (!session('role_id') == 1)) {
            return abort(403);
        }
        $data = [
            'title' => 'Import Database',
            'content' => 'import',
            'logs' => Helper::getLogs(session('id')),
        ];
        return view('layout.index', ['data' => $data]);
    }

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xls,xlsx',
        ], [
            'file.required' => 'Harap isi file!',
            'file.mimes' => 'File yang diterima hanya .xls dan .xlsx',
        ]);
        $file = $request->file('file');
        if ($validator->fails()) {
            $response = [
                'status' => 422,
                'error' => $validator->errors(),
                'file_name' => $file->getClientOriginalName()
            ];
            return response()->json($response);
        } else {
            $nama_file = rand() . $file->getClientOriginalName();
            $file->move(\Storage::path('excel/'), $nama_file);

            $import = new NasabahImport(session('id'));
            Excel::import($import, \Storage::path('excel/' . $nama_file));

            Log::create([
                'user_id' => session('id'),
                'activity' => 'import',
                'description' => json_encode($import->getStatus()),
            ]);

            $response = [
                'status' => 200,
                'message' => 'Berhasil mengimport data nasabah!',
                'import' => $import->getStatus()['import'],
                'skip' => $import->getStatus()['skip'],
                'file_name' => $file->getClientOriginalName()
            ];
            return response()->json($response);
        }
    }
}
