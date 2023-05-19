<?php

namespace App\Http\Middleware;

use Closure;
use Stevebauman\Location\LocationServiceProvider;
use Stevebauman\Location\Drivers\Driver;

class IPAddressCheck
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
      return $next($request);
      
    }
}
