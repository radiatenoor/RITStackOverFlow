<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$role)
    {
        //auth('system_admin')->user()->role;
        //Auth::guard('system_admin')->user()->role;
        if (Auth::guard('system_admin')->user()->role!==$role ){
            return redirect('admin/dashboard');
        }
        return $next($request);
    }
}
