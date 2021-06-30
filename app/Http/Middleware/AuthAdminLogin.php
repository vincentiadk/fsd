<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AuthAdminLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(session()->has('id')) {
            if(session()->get('last_login') != User::find(session()->get('id'))->last_login) {
                session()->flush();
                return redirect('/login');
            }
            return $next($request);
        }

        session()->flush();
        return redirect('/login');
    }
}
