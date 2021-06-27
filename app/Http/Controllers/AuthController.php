<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Log;
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
                    if (Hash::check($password, $query->first()->password)) {
                        session([
                            'id' => $query->first()->id,
                            'username' => $query->first()->username,
                            'role_id' => $query->first()->role_id,
                            'email' => $query->first()->email,
                            'name'  => $query->first()->name,
                        ]);
                        Log::create([
                            'user_id'   => session('id'),
                            'activity'  => 'login'
                        ]);
                        return redirect('admin/dashboard');
                    } else {
                        return redirect()->back()->with([
                            'failed' => 'Maaf, username atau password tidak sesuai.',
                        ]);
                    }
                } else {
                    return redirect()->back()->with([
                        'failed' => 'Maaf, username atau password Anda salah',
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
            'user_id'   => session('id'),
            'activity'  => 'logout'
        ]);
        session()->flush();
        return redirect('/login');
    }
}
