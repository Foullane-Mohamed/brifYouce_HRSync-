<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return $next($request);
        }
        
        return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
    }
}

// app/Http/Middleware/IsHR.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsHR
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && (Auth::user()->isHR() || Auth::user()->isAdmin())) {
            return $next($request);
        }
        
        return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
    }
}
