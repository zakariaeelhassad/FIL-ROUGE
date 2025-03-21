<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'joueur_profile_id' => ['required' ,'exists:joueur_profiles,id'],
            'name_club' => ['required', 'string'],
            'image' => ['nullable ' , 'string'],
            'joining_date' => ['required', 'date'],
            'exit_date' => ['nullable' , 'date'],
            'place' => ['required', 'string'],
            'category_type' => ['required' ,' in:sinyor,jinyor,kadiy,minim'],
        ]);
    
        $experience = Experience::create([
            'joueur_profiles_id' => auth()->id(),
            "name_club" => $request->input('title'),
            "image" => $request->input('image'),
            "joining_date" => $request->input('joining_date'),
            "exit_date" => $request->input('exit_date'),
            "place" => $request->input('place'),
            "category_type" => $request->input('category_type')
        ]);
        return response()->json($experience, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $experience = Experience::with('joueurProfile')->findOrFail($id);
        return response()->json($experience);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $experience = Experience::findOrFail($id);

        $request->validate([
            'joueur_profile_id' => ['required' ,'exists:joueur_profiles,id'],
            'name_club' => ['required', 'string'],
            'image' => ['nullable ' , 'string'],
            'joining_date' => ['required', 'date'],
            'exit_date' => ['nullable' , 'date'],
            'place' => ['required', 'string'],
            'category_type' => ['required' ,' in:sinyor,jinyor,kadiy,minim'],
        ]);

        $experience->update($request->all());
        return response()->json($experience);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $experience = Experience::findOrFail($id);
        $experience->delete();

        return response()->json(['message' => 'Expérience supprimée avec succès']);
    }
}
