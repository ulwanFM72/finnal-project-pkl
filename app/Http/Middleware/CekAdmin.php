<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CekAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('id_user') || session('role') != 'admin') {
            return redirect('/');
        }
        return $next($request);
    }
}
