<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // si l'utilisateur n'est pas connecté
        if (!auth()->check()) {
            return redirect('/login');
        }

        // si l'utilisateur n'est pas admin
        if (auth()->user()->type !== 'admin') {
            return redirect('/'); // ou une page "access denied"
        }

        return $next($request);
    }
}
