<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Active
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

                if ($auth->status != 0) {
                    return $next($request);
                } else {
                    return redirect('/login')
                        ->with('error', 'Your account is deactivated. Please contact admin.');
                }
            } else {
                return redirect('/login')
                    ->with('error', 'Please login first.');
            }
}

}
