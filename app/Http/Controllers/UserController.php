<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        if (session('role_id') != 1) {
            return abort(403);
        }
        $data = [
            'title' => 'User Management',
            'content' => 'user',
            'logs' => Helper::getLogs(session('id')),
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
            'aksi',
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
        if ($queryData != false) {
            $nomor = $start + 1;
            foreach ($queryData as $val) {
                $aksi = "";
                if ($val->enable == 1) {
                    $aksi .= "<button class='btn btn-danger' onclick='disableUser($val->id)'>Disable</button>";
                } else {
                    $aksi .= "<button class='btn btn-primary' onclick='enableUser($val->id)'>Enable</button>";
                }
                $response['data'][] = [
                    $nomor,
                    $val->name,
                    $val->username,
                    $val->email,
                    $val->role(),
                    $aksi .
                    "<a href='" . url("admin/user/view/" . $val->id) . "' class='btn btn-success'>Lihat</a>",
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
        if (session('role_id') != 1) {
            return abort(403);
        }
        $data = [
            'title' => $id > 0 ? 'Update User' : 'Tambah User',
            'content' => 'user-form',
            'logs' => Helper::getLogs(session('id')),
        ];

        if ($id > 0) {
            $user = User::findOrFail($id);
            $data['type'] = 'update';
        } else {
            $user = new User;
            $data['type'] = 'create';
        }
        $data['user'] = $user;

        return view('layout.index', ['data' => $data]);
    }

    public function setting()
    {
        $user = User::findOrFail(session('id'));

        $data = [
            'title' => "Pengaturan",
            'content' => 'user-form',
            'logs' => Helper::getLogs(session('id')),
            'user' => $user,
            'type' => 'setting',
        ];
        return view('layout.index', ['data' => $data]);
    }

    public function store()
    {
        Validator::extend('without_spaces', function ($attr, $value) {
            return preg_match('/^\S*$/u', $value);
        });
        $id = request('id');
        $message = '';
        $validator = Validator::make(request()->all(), [
            "name" => "required",
            "username" => $id > 0 ? "required|without_spaces|min:6|unique:users,username," . $id : "required|without_spaces|min:6|unique:users,username",
            "email" => $id > 0 ? "required|email|unique:users,email," . $id : "required|email|unique:users,email",
        ], [
            "name.required" => "Nama wajib di isi!",
            "username.required" => "Username wajib di isi!",
            "username.unique" => "Username telah ada!",
            "username.without_spaces" => "Username tidak boleh menggunakan spasi",
            "username.min" => "Username minimal 6 Karakter!",
            "email.required" => "Email wajib di isi!",
            "email.unique" => "Email Telah Terdaftar!",
            "email.email" => "Email tidak valid!",
        ]);
        if ($validator->fails()) {
            $response = [
                'status' => 422,
                'error' => $validator->errors(),
            ];
        } else {
            if (request('id') > 0) {
                if (request('type') == 'update') {
                    $user = User::findOrFail(request('id'));
                    $user->update([
                        'name' => request('name'),
                        'username' => request('username'),
                        'email' => request('email'),
                        'enable' => request('enable'),
                        'role_id' => request('role_id'),
                    ]);
                    $message .= 'Berhasil menyimpan. ';
                    $response = [
                        'status' => 200,
                        'message' => $message,
                    ];
                }
                if (request('type') == 'setting') {
                    $user = User::findOrFail(request('id'));
                    $user->update([
                        'name' => request('name'),
                        'username' => request('username'),
                        'email' => request('email'),
                    ]);
                    $message .= 'Berhasil menyimpan. ';
                    $response = [
                        'status' => 200,
                        'message' => $message,
                    ];
                    if (request('password') != "") {
                        if (Hash::check(request('password'), $user->password)) {
                            if (request('password_new') == request('password_confirm')) {
                                $user->update([
                                    'password' => Hash::make(request('password_new')),
                                ]);
                                $message .= 'Berhasil ganti password. ';
                                $response = [
                                    'status' => 200,
                                    'message' => $message,
                                ];
                            } else {
                                $response = [
                                    'status' => 422,
                                    'error' => ['Konfirmasi password salah'],
                                ];
                            }
                        } else {
                            $response = [
                                'status' => 422,
                                'error' => ['Password lama salah'],
                            ];
                        }
                    }
                }
            } else {
                $user = User::create([
                    'name' => request('name'),
                    'username' => request('username'),
                    'email' => request('email'),
                    'enable' => request('enable'),
                    'role_id' => request('role_id'),
                ]);
                $response = [
                    'status' => 200,
                    'message' => 'Berhasil menyimpan',
                    'id' => $user->id,
                ];
            }
        }
        return response()->json($response);
    }

    public function enable()
    {
        if (session('role_id') != 1) {
            return abort(403);
        }
        User::where('id', request('id'))->update(['enable' => 1]);
        $response = [
            'status' => 200,
            'message' => 'Berhasil menyimpan',
        ];
        return response()->json($response);
    }

    public function disable()
    {
        if (session('role_id') != 1) {
            return abort(403);
        }
        User::where('id', request('id'))->update(['enable' => 0]);
        $response = [
            'status' => 200,
            'message' => 'Berhasil menyimpan',
        ];
        return response()->json($response);
    }
}
