<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = $this->userService->all();
        return view('components.reseau.follower', compact('users'));
    }

    public function create()
    {
        return view('pages.signup');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8', 'confirmed'],
            'role' => ['required', 'in:joueur,club_admin,admin'],
        ]);

        try {
            
            $user = $this->userService->create($data);

            if ($user->role === 'club_admin') {
                \App\Models\ClubAdminProfile::create([
                    'user_id' => $user->id,
                    'description' => '',
                    'ecile' => '',
                    'Tactique' => '',
                    'Gestion' => '',
                ]);
            }else {
                \App\Models\JoueurProfile::create([
                    'user_id' => $user->id,
                ]);
            }

            Auth::login($user);
            return redirect()->route('profil.joueur') 
                ->with('success', 'Compte créé avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Erreur lors de la création : ' . $e->getMessage()]);
        }
    }

    public function show(int $id)
    {
        $user = $this->userService->find($id);

        if (!$user instanceof User) {
            return redirect()->back()->withErrors(['error' => 'Utilisateur non trouvé.']);
        }

        return view('users.show', compact('user'));
    }

    public function edit(int $id)
    {
        $user = $this->userService->find($id);

        if (!$user instanceof User) {
            return redirect()->back()->withErrors(['error' => 'Utilisateur non trouvé.']);
        }

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'profile_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png'],
            'banner_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png'],
        ]);

        $user = Auth::user();

        if ($request->hasFile('profile_image')) {
            $profileImagePath = $request->file('profile_image')->store('profile_images', 'public');
            $data['profile_image'] = $profileImagePath;
        }

        if ($request->hasFile('banner_image')) {
            $bannerImagePath = $request->file('banner_image')->store('banner_images', 'public');
            $data['banner_image'] = $bannerImagePath;
        }

        $result = $this->userService->update($data, $id);

        if ($result <= 0) {
            return redirect()->back()->withErrors(['error' => 'Échec de la mise à jour.']);
        }

        return redirect()->route('profil.joueur')->with('success', 'Profil mis à jour avec succès.');
    }

    public function destroy(int $id)
    {
        $result = $this->userService->delete($id);

        return redirect()->back()->with('success', 'Utilisateur supprimé avec succès.');
    }
}
