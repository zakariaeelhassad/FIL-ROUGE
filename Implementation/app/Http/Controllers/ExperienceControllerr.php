<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Services\ExperienceService;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    protected ExperienceService $experienceService;

    public function __construct(ExperienceService $experienceService)
    {
        $this->experienceService = $experienceService;
    }

    public function index()
    {
        $experiences = $this->experienceService->all();

        return response()->json([
            'status' => 'successz',
            'data' => $experiences
        ], 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name_club' => ['required', 'string'],
            'image' => ['nullable ' , 'string'],
            'joining_date' => ['required', 'date'],
            'exit_date' => ['nullable' , 'date'],
            'place' => ['required', 'string'],
            'category_type' => ['required' ,' in:sinyor,jinyor,kadiy,minim'],
        ]);

        $experience = $this->experienceService->create($data);

        if (!$experience instanceof Experience) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create post'
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'data' => $experience,
        ], 201);
    }


    public function show(int $id)
    {
        $experience = $this->experienceService->find($id);

        if (!$experience instanceof Experience) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $experience
        ], 200);
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'joueur_profile_id' => ['required' ,'exists:joueur_profiles,id'],
            'name_club' => ['required', 'string'],
            'image' => ['nullable ' , 'string'],
            'joining_date' => ['required', 'date'],
            'exit_date' => ['nullable' , 'date'],
            'place' => ['required', 'string'],
            'category_type' => ['required' ,' in:sinyor,jinyor,kadiy,minim'],
        ]);

        $result = $this->experienceService->update($data, $id);

        if ($result <= 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update Post'
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Post updated successfully'
        ],200);
    }

    public function destroy(int $id)
    {
        $result = $this->experienceService->delete($id);

        // if (!is_bool($result)) {
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'Failed to delete Post'
        //     ], 500);
        // }

        return response()->json([
            'status' => 'success',
            'message' => 'Post deleted successfully'
        ], 200);
    }
}
