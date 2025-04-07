<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

        return response()->json([
            'status' => 'success',
            'data' => $users
        ], 200);
    }

    public function store(Request $request)
{
    $data = $request->validate([
        'full_name' => ['required', 'string', 'max:255'],
        'username' => ['required', 'string', 'max:255', 'unique:users'],
        'email' => ['required', 'email', 'unique:users'],
        'password' => ['required', 'min:8', 'confirmed'],
        'role' => ['required', 'in:joueur,manager,club_admin,admin'],
    ]); 

    try {
        $user = $this->userService->create($data);
        $token = $user->createToken($user->username);
        Auth::login($user);

        return response()->json([
            'status' => 'success',
            'data' => $user,
            'token' => $token
        ], 201);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to create user: ' . $e->getMessage()
        ], 500);
    }
}


    public function show(int $id)
    {
        $user = $this->userService->find($id);

        if (!$user instanceof User) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $user
        ], 200);
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8', 'confirmed'],
            'role' => ['required', 'in:joueur,manager,club_admin,admin'],
        ]);

        $result = $this->userService->update($data, $id);

        if ($result <= 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update user'
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'User updated successfully'
        ],200);
    }

    public function destroy(int $id)
    {
        $result = $this->userService->delete($id);

        // if (!is_bool($result)) {
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'Failed to delete user'
        //     ], 500);
        // }

        return response()->json([
            'status' => 'success',
            'message' => 'User deleted successfully'
        ], 200);
    }
}
