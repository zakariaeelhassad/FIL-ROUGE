<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Invitation;
use App\Models\JoueurProfile;
use App\Models\User;
use App\Models\ClubAdminProfile;
use App\Models\Message;
use App\Models\Post;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function profil()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour accéder à ce profil.');
        }

        $user = auth()->user();

        return $this->handleProfilView($user);
    }

    public function showprofil($id)
    {
        $user = User::findOrFail($id);

        return $this->handleProfilView($user);
    }

    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'Utilisateur non trouvé.');
        }

        $posts = $user->posts;

        if ($user->role === 'joueur') {
            return view('profil.joueur', compact('user', 'posts'));
        } elseif ($user->role === 'club_admin') {
            $profile = $user->clubAdminProfile;

            $profileData = $profile ? [
                'description' => $profile->description,
                'ecile' => $profile->ecile,
                'tactique' => $profile->Tactique,
                'gestion' => $profile->Gestion,
            ] : null;

            return view('profil.club_admin', compact('user', 'posts', 'profileData'));
        }

        return redirect()->back()->with('error', 'Rôle non autorisé.');
    }

    public function getAuthenticatedProfile()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter.');
        }

        return $this->handleProfilView(auth()->user());
    }

    private function handleProfilView(User $user)
    {
        if ($user->role === 'joueur') {
            return $this->renderJoueurProfil($user);
        }

        if ($user->role === 'club_admin') {
            return $this->renderClubProfil($user);
        }

        if ($user->role === 'admin') {
            return $this->renderadmin($user);
        } 

        return view('page.profil_default', compact('user'));
    }

    private function renderadmin(User $user){
        $users = User::where('id', '!=', auth()->id())->paginate(5);
        $posts = Post::paginate(2);
        $chats = Chat::with('messages')  
        ->orderByDesc(function ($query) {
            $query->select('created_at') 
                  ->from('messages')
                  ->whereColumn('messages.chat_id', 'chats.id')
                  ->latest()  
                  ->limit(1);  
        })
        ->paginate(5);

        $reports = Report::with('reporter')  
                     ->latest()
                     ->paginate(5);

        $totalChats = Message::count();
        $totalReports = Report::count();
        


        return view('pages.dashboard', compact('users' , 'posts' , 'chats' , 'reports' , 'totalChats' , 'totalReports'));
    }

    private function renderJoueurProfil(User $user)
    {
        $profile = $user->joueurProfile;
        $posts = $user->posts()->with('user')->latest()->get();
        $experiences = $user->joueurProfile->experiences()->latest()->get();
        $invitations = Invitation::where('joueur_id', $profile->id)->with(['club.user'])->get();
        $experiencesCount = $user->joueurProfile->experiences()->count();

        return view('pages.profil_joueur', compact('user', 'posts', 'profile', 'experiences', 'experiencesCount', 'invitations'));
    }

    private function renderClubProfil(User $user)
    {
        $profile = $user->clubAdminProfile;
        $posts = $user->posts()->with('user')->latest()->get();
        $titres = $user->clubAdminProfile->titres()->latest()->get();
        $socialMedia = $user->socialMedia ?? null;
        $titresCount = $user->clubAdminProfile->titres()->count();
        
        $data = $this->getAvailableJoueursForClub($profile->id);
        extract($data); 

        return view('pages.profil_club_manager', compact('user', 'posts', 'profile', 'titres', 'titresCount'));
    }

    private function getAvailableJoueursForClub($clubId)
    {
        $invitations = Invitation::where('club_id', $clubId)->with('joueur.user')->get();
        $clubMembers = JoueurProfile::where('club_id', $clubId)->with('user')->get();
        $joueurs = User::where('role', 'joueur')->with('joueurProfile')->get();

        $clubJoueurIds = $clubMembers->pluck('id')->toArray();
        $invitedJoueurIds = $invitations->pluck('joueur_id')->toArray();

        $availableJoueurs = $joueurs->filter(function ($joueur) use ($invitedJoueurIds, $clubJoueurIds) {
            if (!$joueur->joueurProfile) return false;
            return !in_array($joueur->joueurProfile->id, $invitedJoueurIds) &&
                   !in_array($joueur->joueurProfile->id, $clubJoueurIds);
        });

        return compact('invitations', 'clubMembers', 'availableJoueurs', 'joueurs');
    }
}
