<?php
namespace App\Http\Controllers;

use App\Models\ClubAdminProfile;
use App\Models\User;
use Illuminate\Http\Request;

class ClubAdminProfileController extends Controller
{
    public function show($userId)
    {
        // نحصل على البروفايل الخاص بالـ Club Admin
        $profile = ClubAdminProfile::where('user_id', $userId)->first();

        if (!$profile) {
            return view('errors.profile_not_found'); // صفحة تعرض خطأ "Profile not found"
        }

        return view('profiles.show', compact('profile')); // صفحة لعرض البروفايل
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'description' => 'required|string',
        ]);

        $profile = ClubAdminProfile::create([
            'user_id' => $request->user_id,
            'description' => $request->description,
            'ecile' => '', 
            'Tactique' => '', 
            'Gestion' => '',
        ]);

        return redirect()->route('profiles.show', ['userId' => $profile->user_id]) // إعادة توجيه إلى صفحة البروفايل
            ->with('message', 'Profile created successfully');
    }

    public function update(Request $request, $userId)
    {
        $profile = ClubAdminProfile::where('user_id', $userId)->first();

        if (!$profile) {
            return view('errors.profile_not_found'); // صفحة تعرض خطأ "Profile not found"
        }

        $profile->update($request->only(['description', 'ecile', 'Tactique', 'Gestion']));

        return redirect()->route('profiles.show', ['userId' => $profile->user_id])
            ->with('message', 'Profile updated successfully');
    }

    public function destroy($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return view('errors.user_not_found'); // صفحة تعرض خطأ "User not found"
        }

        $user->delete();

        return redirect()->route('') // إعادة التوجيه إلى الصفحة الرئيسية أو أي صفحة أخرى
            ->with('message', 'User and profile deleted successfully');
    }

    public function createProfileForUser($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return view('errors.user_not_found'); // صفحة تعرض خطأ "User not found"
        }

        if ($user->clubAdminProfile) {
            return view('errors.profile_exists'); // صفحة تعرض خطأ "Profile already exists"
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
