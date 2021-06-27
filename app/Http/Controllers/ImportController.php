<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\Log;
use App\Imports\NasabahImport;

class ImportController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Import Database',
            'content' => 'import',
        ];
        return view('layout.index', ['data' => $data]);
    }

    public function import(Request $request)
    {
        //Validasi
		$this->validate($request, [
			'excel' => 'required|mimes:xls,xlsx'
		]);
		
		$file = $request->file('excel');
		$nama_file = rand().$file->getClientOriginalName();
		$file->move('excel', $nama_file);
		
		Excel::import(new NasabahImport, public_path('excel/'.$nama_file));

		Log::create([
            'user_id'   => session('id'),
            'activity'  => 'import'
        ]);
		session()->flash('success', 'Berhasil mengimport data nasabah!');
            $response = [
                'status' => 200,
                'message' => 'Berhasil mengimport',
            ];
        return response()->json($response);
    }
}
