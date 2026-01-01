<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsTrainer
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

        if (Auth::check()) {
            $auth = Auth::user();
            if ($auth->role == 'trainer') {

                return $next($request);
            } else {
                return back();
            }
        } else {
            return redirect('/');
        }
    }
}
