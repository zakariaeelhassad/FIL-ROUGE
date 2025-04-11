<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    /**
     * Store or remove a like from a post or comment.
     */
    public function store(Request $request, $type, $id)
    {
        if (!in_array($type, ['post', 'comment'])) {
            return redirect()->back()->with('error', 'Type invalide');
        }

        $likeable = $type === 'post'
            ? Post::findOrFail($id)
            : Comment::findOrFail($id);

        $existingLike = $likeable->likes()->where('user_id', Auth::id())->first();

        if ($existingLike) {
            $existingLike->delete();
            return redirect()->back()->with('success', 'Like supprimé avec succès');
        } else {
            $likeable->likes()->create(['user_id' => Auth::id()]);
            return redirect()->back()->with('success', 'Like ajouté avec succès');
        }
    }

    /**
     * Remove a like manually (optional route).
     */
    public function destroy($type, $id)
    {
        if (!in_array($type, ['post', 'comment'])) {
            return redirect()->back()->with('error', 'Type invalide');
        }

        $likeable = $type === 'post'
            ? Post::findOrFail($id)
            : Comment::findOrFail($id);

        $like = $likeable->likes()->where('user_id', Auth::id())->first();

        if ($like) {
            $like->delete();
            return redirect()->back()->with('success', 'Like supprimé avec succès');
        }

        return redirect()->back()->with('error', 'Like non trouvé');
    }
}
