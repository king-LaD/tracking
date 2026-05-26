<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Vérifier si l'utilisateur est connecté
        // 2. Vérifier s'il est administrateur (ex: $user->is_admin == true ou $user->role == 'admin')
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        // Si l'accès est refusé, on redirige vers l'accueil avec un message d'erreur
        return redirect()->route('home')->with('error', 'Accès restreint. Vous devez être administrateur.');
    }
}