<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\NasabahStatusIndex;

class ExportToView implements FromView
{
    use Exportable;

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        $collection = $this->data['data']->get();
        switch ($this->data['view']) {
            case 'export':
                return view($this->data['view'], [
                    'data' => $collection,
                ]);
                break;
            case 'export-performance':
                foreach ($collection as $val) {
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
                }
                \Log::info($response);
                return view($this->data['view'], [
                    'data' => $response,
                ]);
                break;
            default :
            return abort(404);
            break;
        }

    }
}
