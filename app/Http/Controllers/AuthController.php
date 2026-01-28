<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function handleLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // 1. Redirection Admin
            if ($user->type === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            // 2. Redirection Responsable Technique
            if ($user->type === 'responsable_technique') {
                return redirect()->route('resp.dashboard');
            }

            // 3. Redirection Utilisateur Interne (Ton travail)
            // On vérifie si l'utilisateur est un utilisateur interne
            if ($user->type === 'utilisateur_interne') {
                return redirect()->route('internal.dashboard');
            }

            // 4. Par défaut pour les autres (ou si le type n'est pas reconnu)
            return redirect()->route('espace.invite');
        }

        return back()->withErrors([
            'email' => 'Email ou mot de passe incorrect',
        ]);
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
