<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Affiche le formulaire de connexion
    public function showLoginForm()
    {
        // Si l'utilisateur est déjà connecté, on le redirige directement
        if (Auth::check()) {
            return Auth::user()->is_admin 
                ? redirect()->route('admin.packages.index') 
                : redirect()->route('home');
        }

        return view('auth.login');
    }

    // Traite la tentative de connexion
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        // Tentative de connexion (Laravel gère la vérification du mot de passe haché)
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            // Redirection selon le rôle
            if (Auth::user()->is_admin) {
                return redirect()->intended(route('admin.packages.index'))
                    ->with('success', 'Bienvenue dans votre espace d\'administration.');
            }

            // Si ce n'est pas un admin (sécurité supplémentaire)
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Accès restreint aux administrateurs.',
            ]);
        }

        // Si la connexion échoue
        return back()->withErrors([
            'email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
        ])->onlyInput('email');
    }

    // Déconnexion de l'utilisateur
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Vous avez été déconnecté.');
    }
}