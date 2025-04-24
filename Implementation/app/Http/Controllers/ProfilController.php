<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{


    public function profil(){
        $user = auth()->user();
        
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour accéder à ce profil.');
        }
    
        if ($user->role == 'joueur') {
            $experiences = $user->experiences()->with('user')->latest()->get();  
            $profile = \App\Models\JoueurProfile::where('user_id', $user->id)->first();
            $posts = $user->posts()->with('user')->latest()->get();
            $socialMedia = $user->socialMedia ?? null;
    
            return view('pages.profil_joueur', compact('user', 'posts', 'profile' , 'experiences' , 'socialMedia'));
        }
    
        if ($user->role == 'club_admin') {
            $profile = \App\Models\ClubAdminProfile::where('user_id', $user->id)->first();
            $titres = \App\Models\Titre::where('user_id', $user->id)->latest()->get();
            $posts = $user->posts()->with('user')->latest()->get();
            $socialMedia = $user->socialMedia ?? null;
    
            return view('pages.profil_club_manager', compact('user', 'posts', 'profile', 'titres' , 'socialMedia'));
        }
    
        return redirect()->route('home')->with('error', 'Role not found');
    }

    public function showprofil($id) {
        $user = User::findOrFail($id);
        
        if ($user->role === 'club_admin') {
            $profile = \App\Models\ClubAdminProfile::where('user_id', $user->id)->first();
            $titres = \App\Models\Titre::where('user_id', $user->id)->latest()->get();
            $posts = $user->posts()->with('user')->latest()->get();
            $socialMedia = $user->socialMedia ?? null;
    
            return view('pages.profil_club_manager', compact('user', 'posts', 'profile', 'titres' , 'socialMedia'));
        } 
        elseif ($user->role === 'joueur') {
            $experiences = $user->experiences()->with('user')->latest()->get();  
            $profile = \App\Models\JoueurProfile::where('user_id', $user->id)->first();
            $posts = $user->posts()->with('user')->latest()->get();
            $socialMedia = $user->socialMedia ?? null;
    
            return view('pages.profil_joueur', compact('user', 'posts', 'profile' , 'experiences' , 'socialMedia'));
        }
        else {
            return view('page.profil_default', compact('user'));
        }
    }

    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
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
