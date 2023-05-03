<?php

namespace App\Http\Middleware;

use Closure;

class FeatureControl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $feature, $feature2 = null)
    {
        if (session('level') == 'Super Admin') {
            return $next($request);
        }

        $granted = (session('granted_features') != null) ? session('granted_features') : [];
        if (in_array($feature, $granted) || in_array($feature2, $granted)) {
            return $next($request);
        } else {
            return redirect('home')->withErrors(['e' => 'You don\'t have permission to access this page.']);
        }
    }
}
