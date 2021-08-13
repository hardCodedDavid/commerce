<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CompleteProfileMiddleware
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
        if ($user = auth()->user()) {
            if (!($user['phone'] && $user['country'] && $user['state'] && $user['address'] && $user['city'])) {
                return redirect('/account')->with('info', 'Please complete your profile to proceed');
            }
        }
        return $next($request);
    }
}
