<?php

namespace App\Http\Middleware;

use Closure;

class IsSuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user() && $request->user()->is_super_admin) {
            return $next($request);
        }

        $request->session()->flash('warning', 'You must be the website owner to do that!');

        return redirect()->back();
    }
}
