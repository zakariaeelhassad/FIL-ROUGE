<?php

namespace App\Http\Controllers;

use App\Services\TitreService;
use Illuminate\Http\Request;
use App\Models\Titre;
use Illuminate\Support\Facades\Storage;

class TitreController extends Controller
{
    protected TitreService $titreService;

    public function __construct(TitreService $titreService)
    {
        $this->middleware('auth');
        $this->titreService = $titreService;
    }

    public function index()
    {
        $titres = $this->titreService->all();
        return view('components.profil.profil_club_admin.titre', compact('titres'));
    }

    public function create()
    {
        return view('titres.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom_titre' => 'required|string|max:255',
            'nombre' => 'required|integer|min:1',
            'description_titre' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);        

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('titres', 'public');
        }

        $this->titreService->create($data);

        return redirect()->route('profil.joueur')->with('success', 'Titre créé avec succès.');
    }

    public function show(int $id)
    {
        $titre = $this->titreService->find($id);

        if (!$titre) {
            return redirect()->back()->with('error', 'Titre introuvable.');
        }

        $user = $titre->user;

        return view('components.profil.profil_club_admin.titre', compact('titre' , 'user'));
    }


    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'nom_titre' => 'required|string|max:255',
            'nombre' => 'required|integer|min:1',
            'description_titre' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'remove_image' => 'nullable|boolean',
        ]);

        $titre = Titre::findOrFail($id);

        if ($titre->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Action non autorisée');
        }

        $titre->nom_titre = $data['nom_titre'];
        $titre->nombre = $data['nombre'];
        $titre->description_titre = $data['description_titre'] ?? null;

        if ($request->has('remove_image') && $titre->image) {
            Storage::disk('public')->delete($titre->image);
            $titre->image = null;
        }

        if ($request->hasFile('image')) {
            if ($titre->image) {
                Storage::disk('public')->delete($titre->image);
            }

            $titre->image = $request->file('image')->store('titres', 'public');
        }

        $titre->save();

        return redirect()->route('profil.joueur')->with('success', 'Titre mis à jour avec succès.');
    }  


    public function destroy(int $id)
    {
        $this->titreService->delete($id);
        return redirect()->route('profil.joueur')->with('success', 'Titre supprimé avec succès.');
    }
}
