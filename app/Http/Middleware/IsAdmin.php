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
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        // If not admin, redirect or abort
        abort(403, 'Unauthorized action.'); // You can redirect to a different page or show a 403 error
        // return redirect('/')->with('error', 'You do not have admin access.');
    }
}