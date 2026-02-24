<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $role = $request->route('role');

        // ما كايناش session login
        if(!session()->has('role')){
            return redirect('/');
        }

        // role ما مطابقش
        if(session('role') != $role){
            abort(403);
        }

        return $next($request);
    }
}