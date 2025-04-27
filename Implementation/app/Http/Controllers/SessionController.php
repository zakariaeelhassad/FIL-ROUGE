<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{

    public function showLoginForm()
    {   
        return view('pages.login');
    }

   public function login(Request $request)
   {
       $credentials = $request->only(['email', 'password']);
       
       $user = User::where('email', $credentials['email'])->first();
   
       if ($user && Hash::check($credentials['password'], $user->password)) {
           Auth::login($user);
           return redirect('/')->with('success', 'Welcome! Login successful.');
       }
   
       return back()->withErrors([
           'email' => 'Email or password incorrect.',
       ])->withInput();
   }
   
    
    


    /**
     * Déconnexion de l'utilisateur
     */
    public function logout(Request $request)
    {
        Log::info('Déconnexion', [
            'user_id' => Auth::id(),
            'ip' => $request->ip()
        ]);

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

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
            5 
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
