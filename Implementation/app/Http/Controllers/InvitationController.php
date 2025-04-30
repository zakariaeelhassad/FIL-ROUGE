<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\JoueurProfile;
use App\Models\User;
use App\Models\ClubAdminProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InvitationController extends Controller
{
    public function index()
    {
        $clubProfile = auth()->user()->clubAdminProfile;

        if (!$clubProfile) {
            return redirect()->back()->with('error', 'Vous n\'avez pas de profil de club.');
        }

        $invitations = Invitation::where('club_id', $clubProfile->id)
            ->with('joueur.user')
            ->get();

        $clubMembers = JoueurProfile::where('club_id', $clubProfile->id)
            ->with('user')
            ->get();

        $joueurs = User::where('role', 'joueur')
            ->with('joueurProfile')
            ->get();

        $clubJoueurIds = JoueurProfile::where('club_id', $clubProfile->id)
            ->pluck('id')
            ->toArray();

        $invitedJoueurIds = Invitation::where('club_id', $clubProfile->id)
            ->pluck('joueur_id')
            ->toArray();

        $availableJoueurs = $joueurs->filter(function($joueur) use ($invitedJoueurIds, $clubJoueurIds) {
            if (!$joueur->joueurProfile) {
                return false;
            }
            return !in_array($joueur->joueurProfile->id, $invitedJoueurIds) &&
                   !in_array($joueur->joueurProfile->id, $clubJoueurIds);
        });

        return view('components.profil.profil_club_admin.personne', compact('invitations', 'clubMembers', 'availableJoueurs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'joueur_id' => 'required|exists:joueur_profiles,id',
        ]);

        $clubProfile = auth()->user()->clubAdminProfile;

        if (!$clubProfile) {
            return redirect()->back()->with('error', 'Vous n\'avez pas de profil de club.');
        }

        $existingInvitation = Invitation::where('club_id', $clubProfile->id)
            ->where('joueur_id', $request->joueur_id)
            ->first();

        if ($existingInvitation) {
            return redirect()->back()->with('error', 'Une invitation a déjà été envoyée à ce joueur.');
        }

        Invitation::create([
            'club_id' => $clubProfile->id,
            'joueur_id' => $request->joueur_id,
            'status' => 'pending',
        ]);

        return redirect()->route('profil.joueur')->with('success', 'Invitation envoyée avec succès.');
    }

    public function acceptInvitation($id)
    {
        $invitation = Invitation::findOrFail($id);
        $joueurProfile = auth()->user()->joueurProfile;

        if (!$joueurProfile || $joueurProfile->id != $invitation->joueur_id) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à accepter cette invitation.');
        }

        $clubName = ClubAdminProfile::find($invitation->club_id)->user->name ?? 'le club';

        $invitation->status = 'accepted';
        $invitation->save();

        $joueurProfile->club_id = $invitation->club_id;
        $joueurProfile->save();

        return redirect()->route('profil.joueur')->with('acceptedClubName', $clubName);
    }

    public function rejectInvitation($id)
    {
        $invitation = Invitation::findOrFail($id);
        $joueurProfile = auth()->user()->joueurProfile;

        if (!$joueurProfile || $joueurProfile->id != $invitation->joueur_id) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à rejeter cette invitation.');
        }

        $clubName = ClubAdminProfile::find($invitation->club_id)->user->name ?? 'le club';

        $invitation->status = 'rejected';
        $invitation->delete();

        return redirect()->route('profil.joueur')->with('success', 'Vous avez rejeté l\'invitation de ' . $clubName);
    }

    public function playerInvitations()
    {
        $joueurProfile = auth()->user()->joueurProfile;

        if (!$joueurProfile) {
            return redirect()->back()->with('error', 'Vous n\'avez pas de profil de joueur.');
        }

        $currentClub = null;
        if ($joueurProfile->club_id) {
            $currentClub = ClubAdminProfile::with('user')->find($joueurProfile->club_id);
        }

        $invitations = Invitation::where('joueur_id', $joueurProfile->id)
            ->with(['club.user'])
            ->get();

        return view('components.profil.profil_joueur.invitations', compact('invitations', 'currentClub', 'joueurProfile'));
    }
}
