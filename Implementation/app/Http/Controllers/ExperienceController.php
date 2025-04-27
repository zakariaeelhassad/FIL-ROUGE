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

        return view('experiences.index', compact('experiences'));
    }

    public function create()
    {
        return view('experiences.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nameClub' => ['required', 'string'],
            'image' => ['nullable', 'image'],
            'joiningDate' => ['required', 'date'],
            'exitDate' => ['nullable', 'date'],
            'place' => ['required', 'string'],
            'categoryType' => ['required', 'in:sinyor,jinyor,kadiy,minim'],
        ]);

        $data['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('experince', 'public');
        }
        $experience = $this->experienceService->create($data);

        if (!$experience instanceof Experience) {
            return redirect()->back()->with('error', 'Échec de création de l\'expérience.');
        }

        return redirect()->route('profil.joueur')->with('success', 'Expérience créée avec succès.');
    }

    public function show(int $id)
    {
        $experience = $this->experienceService->find($id);

        if (!$experience instanceof Experience) {
            return redirect()->route('experiences.index')->with('error', 'Expérience introuvable.');
        }

        return view('experiences.show', compact('experience'));
    }

    public function edit(int $id)
    {
        $experience = $this->experienceService->find($id);

        if (!$experience instanceof Experience) {
            return redirect()->route('experiences.index')->with('error', 'Expérience introuvable.');
        }

        return view('experiences.edit', compact('experience'));
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'joueur_profile_id' => ['required', 'exists:joueur_profiles,id'],
            'name_club' => ['required', 'string'],
            'image' => ['nullable', 'string'],
            'joining_date' => ['required', 'date'],
            'exit_date' => ['nullable', 'date'],
            'place' => ['required', 'string'],
            'category_type' => ['required', 'in:sinyor,jinyor,kadiy,minim'],
        ]);

        $result = $this->experienceService->update($data, $id);

        if ($result <= 0) {
            return redirect()->back()->with('error', 'Échec de mise à jour de l\'expérience.');
        }

        return redirect()->route('experiences.index')->with('success', 'Expérience mise à jour avec succès.');
    }

    public function destroy(int $id)
    {
        $this->experienceService->delete($id);

        return redirect()->route('profil.joueur')->with('success', 'Expérience supprimée avec succès.');
    }
}
