<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\Nasabah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UploadController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Upload Dokumen Nasabah (PDF)',
            'content' => 'upload',
            'logs' => Helper::getLogs(session('id')),
        ];
        return view('layout.index', ['data' => $data]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:pdf',
        ], [
            'file.required' => 'Harap isi file!',
            'file.mimes' => 'File yang diterima hanya .pdf',
        ]);
        $file = $request->file('file');

        if ($validator->fails()) {
                $status = 'validasi';
                $message = json_encode($validator->errors());
        } else {
            $fileName = $file->getClientOriginalName();

            $no_rek = explode('.', $file->getClientOriginalName())[0];
            $fileNameEnkrip = \Str::random(40) . '.pdf';
            $message = "";
            $status = "sukses";
            $nasabah = Nasabah::where('no_rek', $no_rek)->first();
            if ($nasabah) {
                $file->move(\Storage::path('nasabah'), $fileNameEnkrip);
                if ($nasabah->status == 'kosong') {
                    $nasabah->update([
                        'status' => 'baru',
                        'upload_user' => session('id'),
                        'status_time' => now(),
                        'upload_time' => now(),
                        'nama_file' => $fileNameEnkrip,
                    ]);
                    $message = "Nasabah $no_rek sukses diupload";
                } else if ($nasabah->status == 'baru') {
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
        }
        return response()->json(["status" => $status, "message" => $message]);
    }
}
