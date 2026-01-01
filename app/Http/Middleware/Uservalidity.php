<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Uservalidity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect('/');
        }

        $auth = Auth::user();
        if (in_array($auth->role, ['admin', 'trainer'])) {
            return $next($request);
        }
        if ($auth->created_at->addDays(15)->isFuture()) {
            return $next($request);
        }

        Auth::logout();
        return redirect()->route('login')->with('error', 'Your 10-day access period has expired.');
    }
}
