<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Helper\Helper;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        if ((!in_array('role', json_decode(session('permissions')))) && (!session('role_id') == 1)) {
            return abort(403);
        }
        $data = [
            'title' => 'Role Management',
            'content' => 'role',
            'logs' => Helper::getLogs(session('id')),
        ];
        return view('layout.index', ['data' => $data]);
    }
    public function datatable(Request $request)
    {
        $whereLike = [
            'id',
            'name',
            'aksi',
        ];

        $start = $request->input('start');
        $length = $request->input('length');
        $order = $whereLike[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');
        $totalData = Role::count();

        $filtered = Role::where('name', 'like', "%{$search}%");

        $totalFiltered = $filtered->count();
        $queryData = $filtered->offset($start)
            ->limit($length)
            ->orderBy($order, $dir)
            ->get();
        $response['data'] = [];
        if ($queryData != false) {
            $nomor = $start + 1;
            foreach ($queryData as $val) {
                $aksi = "";
                if($val->id != 1) {
                    $aksi = "<a href='" . url("admin/permission/view/" . $val->id) . "' class='btn btn-success'><i class='fas fa-key nav-icon'></i>Atur Hak Akses</a>";
                }
                $response['data'][] = [
                    $nomor,
                    $val->name,
                    $aksi,
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

    public function view($id)
    {
        if( !in_array('view-permission', json_decode(session('permissions'))) && (!session('role_id') == 1) ) {
            return abort(403);
        }
        $data = [
            'title' => 'Lihat Hak Akses',
            'content' => 'permission-form',
            'logs' => Helper::getLogs(session('id')),
            'role'  => Role::findOrFail($id)
        ];

        return view('layout.index', ['data' => $data]);
    }

    public function store()
    {
        if ((!in_array('simpan-role', json_decode(session('permissions')))) && (!session('role_id') == 1)) {
            return abort(403);
        }
        $validator = Validator::make(request()->all(), [
            "name" => "required",
        ], [
            "name.required" => "Nama Role wajib di isi!",
        ]);
        if ($validator->fails()) {
            $response = [
                'status' => 422,
                'error' => $validator->errors(),
            ];
        } else {
            if (request('id') > 0) {
                $role = Role::findOrFail(request('id'));
                $role->update([
                    'name' => request('name'),
                ]);
                $message .= 'Berhasil menyimpan. ';
                $response = [
                    'status' => 200,
                    'message' => $message,
                ];
            } else {
                $role = Role::create([
                    'name' => request('name'),
                ]);
                $response = [
                    'status' => 200,
                    'message' => 'Berhasil menyimpan',
                    'id' => $user->id,
                ];
            }
        }
        return response()->json($response);
        $id = request('id');
    }

    public function storePermission()
    {
        if( !in_array('simpan-permission', json_decode(session('permissions'))) && (!session('role_id') == 1)) {
            return abort(403);
        }
        $role_id = request('id');
        $role = Role::findOrFail($role_id);
        $permissions = json_decode($role->permissions);
        $access = request('access');
        $accessTrue = in_array($access, $permissions);

        if($accessTrue) {
            for($i=0 ; $i < count($permissions) ; $i++){
                if($permissions[$i] == $access) {
                    unset($permissions[$i]);
                }
            }
            $permissions_new = [];
            foreach($permissions as $key=>$val) {
                array_push($permissions_new, $val);
            }
            $role = $role->update([
                'permissions' => $permissions_new,
            ]);
            return response()->json(200);
        } else {
            array_push($permissions, $access);
            $role = $role->update([
                'permissions' => $permissions,
            ]);
            return response()->json(200);
        }
    }
}
