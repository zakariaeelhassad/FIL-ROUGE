<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::with('user', 'comments', 'likes')->get(); 
        return response()->json($posts);
    }
    /**
     * Display a listing of the resource.
     */
    public function myPosts()
    {
        $posts = Post::where('user_id', auth()->id())
                 ->with('user:id,username,full_name')
                 ->get();

        return response()->json([
            'message' => 'Liste des posts récupérée avec succès.',
            'posts' => $posts
        ], 200);
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
        $validated = $request->validate([
            'content' => ['required', 'string'],
            'image' => ['required', 'string']
        ]);

        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'message' => 'Post introuvable.'
            ], 404);
        }

        $post->content = $validated['content'];
        $post->image = $validated['image'];
        $post->save();

        return response()->json([
            'message' => 'Post modifié avec succès.',
            'post' => $post
        ], 200);
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
    

    public function likePost(Request $request, $postId)
    {
        $user = auth()->user();

        $post = Post::findOrFail($postId);

        $like = Like::where('user_id', $user->id)->where('post_id', $postId)->first();

        if ($like) {
            $like->delete();
            return $request->json([
                'status' => 'success',
                'message' => 'Like supprimé',
                'liked' => false
            ], 200);
        } else {
            Like::create([
                'user_id' => $user->id,
                'post_id' => $postId
            ]);
            return $request->json([
                'status' => 'success',
                'message' => 'Post liké',
                'liked' => true
            ], 201);
        }
    }
}
