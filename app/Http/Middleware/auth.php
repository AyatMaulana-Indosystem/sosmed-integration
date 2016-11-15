<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class auth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Session::has('facebook') || Session::has('twitter') || Session::has('instagram')) 
        {
            return $next($request);
        }
        else{
            return redirect('/');
        }
    }
}
