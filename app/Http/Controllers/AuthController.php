<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function register(Request $request)
    {
        $attributes = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8', 'confirmed'],
            'role' => ['required', 'in:joueur,manager,club_admin,admin'],
        ]);

        $attributes['full_name'] = $attributes['full_name'] ?? 'Nom non fourni';

        $attributes['role'] = $attributes['role'] ?? 'joueur';
        $attributes['password'] = Hash::make($attributes['password']);

        $user = User::create($attributes);
        $token = $user->createToken('apptoken')->plainTextToken;

        Auth::login($user);

        return response()->json([
            'message' => 'Utilisateur créé avec succès',
            'token'   => $token
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
