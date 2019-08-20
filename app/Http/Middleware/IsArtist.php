<?php

namespace App\Http\Middleware;

use Closure;

class IsArtist
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
        if ($request->user() && $request->user()->is_admin || $request->user() && $request->user()->is_artist) {
            return $next($request);
        }

        $request->session()->flash('warning', 'You must be an administrator or an artist to do that!');

        return redirect()->back();
    }
}
