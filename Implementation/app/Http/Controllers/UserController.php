<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function reseau()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->withErrors(['error' => 'Veuillez vous connecter.']);
        }
    
        $users = User::where('id', '!=', auth()->id())->get();
    
        return view('page.reseau', compact('users'));
    }

    public function index()
    {
        $users = $this->userService->all();
        return view('components.reseau.follower', compact('users'));
    }

    public function create()
    {
        return view('page.signup');
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
            Auth::login($user);
            return redirect()->route('login')->with('success', 'Compte créé avec succès.');
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
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $id],
            'email' => ['required', 'email', 'unique:users,email,' . $id],
            'password' => ['required', 'min:8', 'confirmed'],
            'role' => ['required', 'in:joueur,manager,club_admin,admin'],
        ]);

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $result = $this->userService->update($data, $id);

        if ($result <= 0) {
            return redirect()->back()->withErrors(['error' => 'Échec de la mise à jour.']);
        }

        return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour avec succès.');
    }

    public function destroy(int $id)
    {
        $result = $this->userService->delete($id);

        return redirect()->back()->with('success', 'Utilisateur supprimé avec succès.');
    }
}
