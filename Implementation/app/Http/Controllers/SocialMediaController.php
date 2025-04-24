<?php

namespace App\Http\Controllers;

use App\Models\UserSocialMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SocialMediaController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $socialMedia = $user->socialMedia ?? new UserSocialMedia();
        
        return view('components.profil.social_media', compact('socialMedia'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $data = $request->validate([
            'google' => 'nullable|url',
            'twitter' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'instagram' => 'nullable|url',
        ]);

        $user->socialMedia()->updateOrCreate(['user_id' => $user->id], $data);

        return redirect()->back()->with('success', 'Social media links updated successfully!');
    }
}