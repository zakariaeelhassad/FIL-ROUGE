<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
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
            'content' => ['required', 'string'],
            'image' => ['required', 'string']
        ]);

        $post = Post::create([
            'user_id' => auth()->id(),
            'content' => $request->input('content'),
            'image' => $request->input('image'),
        ]);

        return response()->json([
            'message' => 'Post ajouté avec succès !',
            'post' => $post
        ], 201); 
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'message' => 'Post introuvable.'
            ], 404);
        }
    
        $post->delete();
    
        return response()->json([
            'message' => 'Post supprimé avec succès.'
        ], 200);
    }
}
