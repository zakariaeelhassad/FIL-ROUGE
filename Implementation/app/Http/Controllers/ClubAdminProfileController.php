<?php
namespace App\Http\Controllers;

use App\Models\ClubAdminProfile;
use App\Models\User;
use Illuminate\Http\Request;

class ClubAdminProfileController extends Controller
{
    public function show($userId)
    {
        $user = auth()->user();
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour accéder à ce profil.');
        }

        $profile = ClubAdminProfile::where('user_id', $userId)->first();
        $posts = $user->posts()->with('user')->latest()->get();

        if (!$profile) {
            return view('errors.profile_not_found'); 
        }

        return view('pages.profil_club_manager', compact('user', 'posts', 'profile'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'description' => 'required|string',
        ]);

        $profile = ClubAdminProfile::create([
            'user_id' => $request->user_id,
            'description' => '',
            'ecile' => '', 
            'Tactique' => '', 
            'Gestion' => '',
        ]);

        return redirect()->route('profiles.show', ['userId' => $profile->user_id]) 
            ->with('message', 'Profile created successfully');
    }

    public function update(Request $request, $userId)
    {
        $profile = ClubAdminProfile::where('user_id', $userId)->first();

        if (!$profile) {
            return view('errors.profile_not_found'); 
        }

        $profile->update($request->only(['description', 'ecile', 'Tactique', 'Gestion']));

        return redirect()->route('profil.joueur', ['userId' => $profile->user_id])
            ->with('message', 'Profile updated successfully');

    }

    public function destroy($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return view('errors.user_not_found'); 
        }

        $user->delete();

        return redirect()->route('') 
            ->with('message', 'User and profile deleted successfully');
    }

    public function createProfileForUser($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return view('errors.user_not_found'); 
        }

        if ($user->clubAdminProfile) {
            return view('errors.profile_exists');
        }

        $profile = ClubAdminProfile::create([
            'user_id' => $userId,
            'description' => 'Default description',
            'ecile' => 'Default ecile',
            'Tactique' => 'Default Tactique',
            'Gestion' => 'Default Gestion',
        ]);

        return redirect()->route('profiles.show', ['userId' => $profile->user_id])
            ->with('message', 'Profile created successfully');
    }
}
