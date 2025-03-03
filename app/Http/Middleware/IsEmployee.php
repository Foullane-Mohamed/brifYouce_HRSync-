<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsEmployee
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->isEmployee()) {
            return $next($request);
        }
        
        return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
    }
}
