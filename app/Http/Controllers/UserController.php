<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Log;

class UserController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'User Management',
            'content' => 'user',
        ];
        return view('layout.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $whereLike = [
            'id',
            'username',
            'nama',
            'email',
            'role_id',
            'aksi'
        ];

        $start = $request->input('start');
        $length = $request->input('length');
        $order = $whereLike[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');
        $totalData = User::count();

        $filtered = User::where(function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        });

        $totalFiltered = $filtered->count();
        $queryData = $filtered->offset($start)
            ->limit($length)
            ->orderBy($order, $dir)
            ->get();
        $response['data'] = [];
        if ($queryData <> false) {
            $nomor = $start + 1;
            foreach ($queryData as $val) {
                $aksi = "";
                if($val->enable == 1) {
                    $aksi .= "<button class='btn btn-danger' onclick='disable($val->id)'>Disable</button>";
                } else {
                    $aksi .= "<button class='btn btn-primary' onclick='enable($val->id)'>Enable</button>";
                }
                $response['data'][] = [
                    $nomor,
                    $val->name,
                    $val->username,
                    $val->email,
                    $val->role(),
                    $aksi
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

    public function view()
    {
        if($id > 0) {
            $user = User::findOrFail($id);
        } else {
            $user = User::class;
        }
    }

    public function store()
    {
        Log::create([
            'user_id'   => session('id'),
            'activity'  => 'tambah user'
        ]);
    }

    public function enable()
    {

    }

    public function disable()
    {

    }
}
