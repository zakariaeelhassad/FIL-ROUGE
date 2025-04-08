<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
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
    public function store(Request $request, $type, $id)
    {
        if (!in_array($type, ['post', 'comment'])) {
            return response()->json(['message' => 'Type invalide'], 400);
        }

        if ($type === 'post') {
            $likeable = Post::findOrFail($id);
        } else {
            $likeable = Comment::findOrFail($id);
        }

        $existingLike = $likeable->likes()->where('user_id', Auth::id())->first();

        if ($existingLike) {
            $existingLike->delete();
            return response()->json(['message' => 'Like supprimé avec succès']);
        } else {
            $like = $likeable->likes()->create(['user_id' => Auth::id()]);
            return response()->json(['message' => 'Like ajouté avec succès', 'like' => $like], 201);
        }
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
    public function destroy($type, $id)
    {
        if (!in_array($type, ['post', 'comment'])) {
            return response()->json(['message' => 'Type invalide'], 400);
        }

        if ($type === 'post') {
            $likeable = Post::findOrFail($id);
        } else {
            $likeable = Comment::findOrFail($id);
        }

        $like = $likeable->likes()->where('user_id', Auth::id())->first();
        if ($like) {
            $like->delete();
            return response()->json(['message' => 'Like supprimé avec succès']);
        }

        return response()->json(['message' => 'Like non trouvé'], 404);
    }

}
