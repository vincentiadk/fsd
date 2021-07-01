<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        if (session('id')) {
            return redirect('admin/dashboard');
        } else {
            if (request()->has('_token')) {
                $username = request('username');
                $password = request('password');
                $fieldType = filter_var(request('username'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
                $query = User::where("$fieldType", $username)->whereNotNull('email_verified_at');

                if ($query->count() > 0) {
                    if ($query->first()->enable == 0) {
                        return redirect()->back()->with([
                            'failed' => 'Maaf, akun Anda tidak aktif.',
                        ]);
                    } else {
                        if (Hash::check($password, $query->first()->password)) {
                            $user = $query->first();
                            $time = now();
                            session([
                                'id' => $user->id,
                                'username' => $user->username,
                                'role_id' => $user->role_id,
                                'email' => $user->email,
                                'name' => $user->name,
                                'last_login' => $time,
                                'permissions' => $user->role->permissions
                            ]);
                            $user->update([
                                'last_login' => $time,
                            ]);
                            Log::create([
                                'user_id' => session('id'),
                                'activity' => 'login',
                            ]);
                            return redirect('admin/dashboard');
                        } else {
                            return redirect()->back()->with([
                                'failed' => 'Maaf, password tidak sesuai.',
                            ]);
                        }
                    }
                } else {
                    return redirect()->back()->with([
                        'failed' => 'Maaf, username/email Anda tidak ditemukan',
                    ]);
                }
            } else {
                return view('login');
            }
        }
    }

    public function logout()
    {
        Log::create([
            'user_id' => session('id'),
            'activity' => 'logout',
        ]);
        session()->flush();
        return redirect('/login');
    }
}
