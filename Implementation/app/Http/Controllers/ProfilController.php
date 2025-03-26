<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{

    public function getAuthenticatedProfile()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not authenticated'
            ], 401);
        }

        $posts = $user->posts;

        if ($user->role === 'joueur') {
            return response()->json([
                'status' => 'success',
                'data' => $user,
                'posts' => $posts,
            ], 200);

        } elseif ($user->role === 'club_admin') {
            $clubAdminProfile = $user->clubAdminProfile;

            $profileData = $clubAdminProfile ? [
                'description' => $clubAdminProfile->description,
                'ecile' => $clubAdminProfile->ecile,
                'tactique' => $clubAdminProfile->Tactique,
                'gestion' => $clubAdminProfile->Gestion,
            ] : null;

            return response()->json([
                'status' => 'success',
                'data' => [
                    'user' => $user,
                    'profile' => $profileData,
                    'posts' => $posts,
                ]
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized role'
            ], 403);
        }
    }
}
