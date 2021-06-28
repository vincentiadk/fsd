<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use App\Models\Log;
use App\Helper\Helper;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Upload Dokumen Nasabah (PDF)',
            'content' => 'upload',
            'logs'  => Helper::getLogs(session('id'))
        ];
        return view('layout.index', ['data' => $data]);
    }

    public function store(Request $request)
    {
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();

        $no_rek = explode('.', $file->getClientOriginalName())[0];

        $message = ""; $status = "sukses";
        $nasabah = Nasabah::where('no_rek', $no_rek)->first();
        if($nasabah) {
            $file->move(public_path('nasabah'), $fileName);
            if($nasabah->status == 'kosong') {
                $nasabah ->update([
                    'status' => 'baru',
                    'upload_user' => session('id'),
                    'status_time'  => now(),
                    'upload_time'  => now(),
                ]);
                $message = "Nasabah $no_rek sukses diupload";
            } else if($nasabah->status == 'baru') {
                $status = "gagal";
                $message = "Nasabah $no_rek sudah pernah diupload";
            } else {
                $status = "gagal";
                $message = "Nasabah $no_rek sedang diindex";
            }
        } else {
            $status = "gagal";
            $message = "Nomor rekening $no_rek tidak ditemukan";
        }
        return response()->json(["status" => $status, "message" => $message]);
    }
}
