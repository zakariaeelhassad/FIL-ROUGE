<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            // Redirect back with error message if user not found
            return redirect()->back()->with('error', 'Utilisateur non trouvé.');
        }

        $posts = $user->posts;

        if ($user->role === 'joueur') {
            return view('profil.joueur', [
                'user' => $user,
                'posts' => $posts
            ]);

        } elseif ($user->role === 'club_admin') {
            $clubAdminProfile = $user->clubAdminProfile;

            $profileData = $clubAdminProfile ? [
                'description' => $clubAdminProfile->description,
                'ecile' => $clubAdminProfile->ecile,
                'tactique' => $clubAdminProfile->Tactique,
                'gestion' => $clubAdminProfile->Gestion,
            ] : null;

            return view('profil.club_admin', [
                'user' => $user,
                'profile' => $profileData,
                'posts' => $posts
            ]);
        } else {
            return redirect()->back()->with('error', 'Rôle non autorisé.');
        }
    }

    public function getAuthenticatedProfile()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter.');
        }

        $posts = $user->posts;

        if ($user->role === 'joueur') {
            return view('profil.joueur', [
                'user' => $user,
                'posts' => $posts
            ]);

        } elseif ($user->role === 'club_admin') {
            $clubAdminProfile = $user->clubAdminProfile;

            $profileData = $clubAdminProfile ? [
                'description' => $clubAdminProfile->description,
                'ecile' => $clubAdminProfile->ecile,
                'tactique' => $clubAdminProfile->Tactique,
                'gestion' => $clubAdminProfile->Gestion,
            ] : null;

            return view('profil.club_admin', [
                'user' => $user,
                'profile' => $profileData,
                'posts' => $posts
            ]);
        } else {
            return redirect()->back()->with('error', 'Rôle non autorisé.');
        }
    }
}
