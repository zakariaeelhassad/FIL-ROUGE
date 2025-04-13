<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function follow($userId)
    {
        $user = auth()->user();
        $followedUser = User::findOrFail($userId);

        if ($user->id == $followedUser->id) {
            return redirect()->back()->with('error', 'Impossible de se connecter à soi-même');
        }

        $existingFollow = Follow::where('follower_id', $user->id)
                                ->where('following_id', $followedUser->id)
                                ->whereIn('status', ['pending', 'accepted'])
                                ->exists();

        if ($existingFollow) {
            return redirect()->back()->with('error', 'Demande déjà envoyée ou déjà connecté');
        }

        Follow::create([
            'follower_id' => $user->id,
            'following_id' => $followedUser->id,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Demande envoyée');
    }

    public function acceptFollow($userId)
    {
        $user = auth()->user();

        $followRequest = Follow::where('follower_id', $userId)
                                ->where('following_id', $user->id)
                                ->where('status', 'pending')
                                ->first();

        if (!$followRequest) {
            return redirect()->back()->with('error', 'No follow request found');
        }

        $followRequest->status = 'accepted';
        $followRequest->save();

        Follow::updateOrCreate(
            [
                'follower_id' => $user->id,
                'following_id' => $userId,
            ],
            [
                'status' => 'accepted',
            ]
        );

        return redirect()->back()->with('success', 'Demande acceptée');
    }

    public function rejectFollow($userId)
    {
        $user = auth()->user();
        $followRequest = Follow::where('follower_id', $userId)
                                ->where('following_id', $user->id)
                                ->where('status', 'pending')
                                ->first();
        if (!$followRequest) {
            return redirect()->back()->with('error', 'No follow request found');
        }

        $followRequest->delete();

        return redirect()->back()->with('success', 'Demande rejetée');
    }

    public function pendingRequests()
    {
        $user = auth()->user();
        $followRequests = $user->pendingFollowers()->with('follower')->get();

        return view('components.reseau.follow', compact('followRequests'));
    }

    public function friendsList()
    {
        $user = auth()->user();
        $friends = $user->friends()->get();
        
        return view('friends', compact('friends'));
    }

    public function unfollow($userId)
    {
        $user = auth()->user();

        $follow = Follow::where('follower_id', $user->id)
                        ->where('following_id', $userId)
                        ->where('status', 'accepted')
                        ->first();

        if ($follow) {
            $follow->delete();

            Follow::where('follower_id', $userId)
                  ->where('following_id', $user->id)
                  ->where('status', 'accepted')
                  ->delete();

            return redirect()->back()->with('success', 'Vous avez supprimé cette connexion.');
        }

        return redirect()->back()->with('error', 'Vous n\'êtes pas connecté avec cette personne.');
    }
}