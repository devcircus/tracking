<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;

class IsTarget
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
        if ($request->user() && $request->user()->is_admin) {
            return $next($request);
        }

        if ($this->authenticatedUserIsTargetUser($request->user(), $request->user)) {
            return $next($request);
        }

        flash('warning', 'You may not perform this action.');

        return redirect()->back();
    }

    /**
     * Check if the authenticated user is also the target of the action being taken.
     */
    public function authenticatedUserIsTargetUser(): bool
    {
        if (is_int(request()->user)) {
            $target = User::find(request()->user);
        } else {
            $target = request()->user;
        }


        return request()->user() == $target;
    }
}
