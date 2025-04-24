<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    /**
     * Follow a user (send a follow request)
     */
    public function follow($userId)
    {
        $user = auth()->user();
        $followedUser = User::findOrFail($userId);

        if ($user->id == $followedUser->id) {
            return redirect()->back()->with('error', 'You cannot follow yourself');
        }

        $existingFollow = Follow::where('follower_id', $user->id)
                                ->where('following_id', $followedUser->id)
                                ->exists();

        if ($existingFollow) {
            return redirect()->back()->with('error', 'You already sent a follow request to this user');
        }

        Follow::create([
            'follower_id' => $user->id,
            'following_id' => $followedUser->id,
            'status' => 'pending'
        ]);

        return redirect()->back()->with('success', 'Follow request sent successfully');
    }

    /**
     * Unfollow a user
     */
    public function unfollow($userId)
    {
        $user = auth()->user();

        $follow = Follow::where('follower_id', $user->id)
                        ->where('following_id', $userId)
                        ->first();

        if ($follow) {
            $follow->delete();
            return redirect()->back()->with('success', 'You have unfollowed this user');
        }

        return redirect()->back()->with('error', 'You are not following this user');
    }

    /**
     * Accept follow request
     */
    public function acceptFollowRequest($followId)
    {
        $follow = Follow::findOrFail($followId);
        
        // Check if the logged in user is the one receiving the follow request
        if ($follow->following_id != auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized action');
        }
        
        $follow->update(['status' => 'accepted']);
        
        return redirect()->back()->with('success', 'Follow request accepted');
    }
    
    /**
     * Reject follow request
     */
    public function rejectFollowRequest($followId)
    {
        $follow = Follow::findOrFail($followId);
        
        // Check if the logged in user is the one receiving the follow request
        if ($follow->following_id != auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized action');
        }
        
        $follow->delete();
        
        return redirect()->back()->with('success', 'Follow request rejected');
    }

    /**
     * Get followers list
     */
    public function followers($userId = null)
    {
        $userId = $userId ?: auth()->id();
        $user = User::findOrFail($userId);
        
        $followers = $user->followers()->with('follower')->where('status', 'accepted')->get();
        $pendingFollowers = $user->followers()->with('follower')->where('status', 'pending')->get();
        
        return view('pages.followers', compact('followers', 'pendingFollowers', 'user'));
    }

    /**
     * Get following list
     */
    public function following($userId = null)
    {
        $userId = $userId ?: auth()->id();
        $user = User::findOrFail($userId);
        
        $following = $user->following()->with('following')->get();
        $pendingFollowing = $user->following()->with('following')->where('status', 'pending')->get();
        $acceptedFollowing = $user->following()->with('following')->where('status', 'accepted')->get();
        
        return view('pages.following', compact('following', 'pendingFollowing', 'acceptedFollowing', 'user'));
    }

    /**
     * Suggested users to follow
     */
    public function suggestions()
    {
        $user = auth()->user();
        
        $followingIds = $user->following()->pluck('following_id')->toArray();
        $followingIds[] = $user->id; 
        
        $suggestedUsers = User::whereNotIn('id', $followingIds)
                            ->inRandomOrder()
                            ->limit(15)
                            ->get();
        
        return view('pages.suggestions', compact('suggestedUsers'));
    }
}