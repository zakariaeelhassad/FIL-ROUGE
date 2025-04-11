<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
     /**
     * Affiche le formulaire de connexion
     */
    public function showLoginForm()
    {
        // Si l'utilisateur est déjà connecté, redirigez-le
        if (Auth::check()) {
            return redirect()->route('reseau'); // Remplacez par votre route de tableau de bord
        }
        
        return view('page.login');
    }

    /**
     * Gère la connexion de l'utilisateur
     */
    public function login(Request $request)
    {
        $attributes = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        var_dump($attributes, User::where('email', $attributes['email'])->first());
        dd(Auth::attempt($attributes));

        if (Auth::attempt($attributes)) {
            $request->session()->regenerate();

            return redirect('reseau')->with('success', 'Connexion réussie !');
        }

        return back()->withErrors([
            'email' => 'Les identifiants sont incorrects.',
        ])->withInput($request->only('email'));
    }


    /**
     * Déconnexion de l'utilisateur
     */
    public function logout(Request $request)
    {
        // Log de la déconnexion
        Log::info('Déconnexion', [
            'user_id' => Auth::id(),
            'ip' => $request->ip()
        ]);

        // Déconnexion
        Auth::logout();

        // Invalidation de la session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirection vers la page de connexion
        return redirect()->route('login')
            ->with('success', 'Vous avez été déconnecté avec succès');
    }

    /**
     * Gestion des tentatives de connexion multiples
     */
    protected function hasTooManyLoginAttempts(Request $request)
    {
        return $this->limiter()->tooManyAttempts(
            $this->throttleKey($request), 
            5 // Nombre maximal de tentatives
        );
    }

    /**
     * Trop de tentatives de connexion
     */
    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        throw ValidationException::withMessages([
            'email' => [trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ])],
        ])->status(429);
    }
}
