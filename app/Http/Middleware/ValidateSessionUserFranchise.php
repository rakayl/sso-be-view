<?php

namespace App\Http\Middleware;

use Closure;

class ValidateSessionUserFranchise
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
        if (session()->has('username-franchise')) {
            return $next($request);
        } else {
            return redirect('disburse/login')->withErrors(['e' => 'Please login.']);
        }
    }
}
