<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Webguard
{
   
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $jobType, $access)
    {
        $user = auth()->user();
        // dd($user);
        // Check if user has the required access
    if ($user->hasAccess($jobType, $access)) {
            return $next($request);
        }
        return error('Unauthorized access.',403);
    }
    
}


