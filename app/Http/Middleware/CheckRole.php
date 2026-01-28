<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
public function handle(Request $request, Closure $next, $role)
{
    // Si l'utilisateur n'est pas connecté ou n'a pas le bon rôle
    if (!auth()->check() || auth()->user()->role !== $role) {
        // On le renvoie vers l'accueil ou la page de login
        return redirect('/')->with('error', "Vous n'avez pas l'accès admin.");
    }

    return $next($request);
}
}
