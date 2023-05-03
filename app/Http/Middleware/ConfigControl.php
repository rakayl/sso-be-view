<?php

namespace App\Http\Middleware;

use Closure;

class ConfigControl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $config, $config2 = null, $or = null)
    {
        $configs = (session('configs') != null) ? session('configs') : [];
        if ($or != null) {
            if (in_array($config, $configs) || in_array($config2, $configs)) {
                return $next($request);
            } else {
                return redirect('home')->withErrors(['e' => 'This feature is not available.']);
            }
        } else {
            if (in_array($config, $configs)) {
                if ($config2 != null) {
                    if (in_array($config2, $configs)) {
                        return $next($request);
                    } else {
                        return redirect('home')->withErrors(['e' => 'This feature is not available.']);
                    }
                } else {
                    return $next($request);
                }
            } else {
                return redirect('home')->withErrors(['e' => 'This feature is not available.']);
            }
        }
    }
}
