<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    protected PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->middleware('auth'); 
        $this->postService = $postService;
    }

    public function profil(){
        $user = auth()->user();
        
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour accéder à ce profil.');
        }
    
        if ($user->role == 'joueur') {
            $experiences = $user->experiences()->with('user')->latest()->get();  
            $profile = \App\Models\JoueurProfile::where('user_id', $user->id)->first();
            $posts = $user->posts()->with('user', 'images')->latest()->get();
    
            return view('pages.profil_joueur', compact('user', 'posts', 'profile' , 'experiences'));
        }
    
        if ($user->role == 'club_admin') {
            $profile = \App\Models\ClubAdminProfile::where('user_id', $user->id)->first();
            $titres = \App\Models\Titre::where('user_id', $user->id)->latest()->get();
            $posts = $user->posts()->with('user', 'images')->latest()->get();
    
            return view('pages.profil_club_manager', compact('user', 'posts', 'profile', 'titres'));
        }
    
        return redirect()->route('home')->with('error', 'Role not found');
    }
    

    public function index()
    {
        $posts = $this->postService->all();

        return view('pages.home', compact('posts'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'content' => ['required', 'string'],
            'image' => ['nullable', 'image', 'max:2048'], 
        ]); 

        $post = new Post();
        $post->user_id = auth()->id();
        $post->content = $data['content'];
        $post->save();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
           
            $post->images()->create([
                'path' => $imagePath
            ]);
        }

        return redirect()->route('posts.index')->with('success', 'Post créé avec succès');
    }

    public function show(int $id)
    {
        $post = $this->postService->find($id);

        if (!$post instanceof Post) {
            return redirect()->back()->with('error', 'Post non trouvé');
        }

        $user = $post->user;

        return view('components.profil.activite', compact('post' , 'user'));
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'content' => ['required', 'string'],
            'image' => ['required', 'string']
        ]);

        $result = $this->postService->update($data, $id);

        if ($result <= 0) {
            return redirect()->back()->with('error', 'Échec de la mise à jour du post');
        }

        return redirect()->route('posts.index')->with('success', 'Post mis à jour avec succès');
    }

    public function destroy(int $id)
    {
        $result = $this->postService->delete($id);

        return redirect()->route('posts.index')->with('success', 'Post supprimé avec succès');
    }
}
