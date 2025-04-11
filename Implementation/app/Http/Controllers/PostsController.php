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

    public function index()
    {
        $posts = $this->postService->all();

        return view('page.home', compact('posts'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'content' => ['required', 'string'],
            'image' => ['required', 'string'],
        ]); 

        $post = $this->postService->create($data);

        if (!$post instanceof Post) {
            return redirect()->back()->with('error', 'Échec de la création du post');
        }

        return redirect()->route('posts.index')->with('success', 'Post créé avec succès');
    }

    public function show(int $id)
    {
        $post = $this->postService->find($id);

        if (!$post instanceof Post) {
            return redirect()->back()->with('error', 'Post non trouvé');
        }

        return view('posts.show', compact('post'));
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
