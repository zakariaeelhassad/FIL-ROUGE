<?php

namespace App\Http\Controllers;

use App\Models\Certification;
use Illuminate\Http\Request;

class CerficationController extends Controller
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
            'title' => ['required', 'string'],
            'content' => ['required', 'string'],
            'creation_date' => ['required', 'date'],
        ]);

        $certification = Certification::create([
            'joueur_profiles_id' => auth()->id(),
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'creation_date' => $request->input('creation_date'),
        ]);
        return response()->json($certification, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $certification = Certification::with('joueurProfile')->findOrFail($id);
        return response()->json($certification);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $certification = Certification::findOrFail($id);

        $request->validate([
            'title' => ['required', 'string'],
            'content' => ['required', 'string'],
            'creation_date' => ['required', 'date'],
        ]);

        $certification->update($request->all());
        return response()->json($certification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $certification = Certification::findOrFail($id);
        $certification->delete();

        return response()->json(['message' => 'Certification supprimée avec succès']);
    }
}
