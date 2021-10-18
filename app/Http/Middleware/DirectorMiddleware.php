<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DirectorMiddleware
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
        if (Auth::user()->role == 'director') {
            return $next($request);
        }
        return redirect(route('employee-index'))->with('message', 'forbidden-employee-access');
    }
}
