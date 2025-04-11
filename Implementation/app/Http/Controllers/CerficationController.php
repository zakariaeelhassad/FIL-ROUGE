<?php

namespace App\Http\Controllers;

use App\Models\Certification;
use Illuminate\Http\Request;

class CertificationController extends Controller
{
    /**
     * Afficher la liste des certifications.
     */
    public function index()
    {
        $certifications = Certification::with('joueurProfile')->latest()->get();
        return view('certifications.index', compact('certifications'));
    }

    /**
     * Afficher le formulaire de création.
     */
    public function create()
    {
        return view('certifications.create');
    }

    /**
     * Enregistrer une nouvelle certification.
     */
    public function store(Request $request)
    {
        $request->validate([
            'joueur_profile_id' => ['required', 'exists:joueur_profiles,id'],
            'title' => ['required', 'string'],
            'content' => ['required', 'string'],
            'creation_date' => ['required', 'date'],
        ]);

        Certification::create([
            'joueur_profile_id' => $request->input('joueur_profile_id'),
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'creation_date' => $request->input('creation_date'),
        ]);

        return redirect()->route('certifications.index')->with('success', 'Certification ajoutée avec succès.');
    }

    /**
     * Afficher une certification spécifique.
     */
    public function show(string $id)
    {
        $certification = Certification::with('joueurProfile')->findOrFail($id);
        return view('certifications.show', compact('certification'));
    }

    /**
     * Afficher le formulaire d'édition.
     */
    public function edit(string $id)
    {
        $certification = Certification::findOrFail($id);
        return view('certifications.edit', compact('certification'));
    }

    /**
     * Mettre à jour une certification.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => ['required', 'string'],
            'content' => ['required', 'string'],
            'creation_date' => ['required', 'date'],
        ]);

        $certification = Certification::findOrFail($id);
        $certification->update($request->all());

        return redirect()->route('certifications.index')->with('success', 'Certification mise à jour avec succès.');
    }

    /**
     * Supprimer une certification.
     */
    public function destroy(string $id)
    {
        $certification = Certification::findOrFail($id);
        $certification->delete();

        return redirect()->route('certifications.index')->with('success', 'Certification supprimée avec succès.');
    }
}
