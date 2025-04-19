<?php
namespace App\Http\Controllers;

use App\Models\Reaction;
use App\Models\Post;
use Illuminate\Http\Request;

class ReactionController extends Controller
{
    /**
     * Store a new reaction for a post.
     */
     public function store(Request $request, $postId)
    {
        $validated = $request->validate([
            'reaction' => 'required|in:like,love,wow,haha,sad,grr',
        ]);

        $post = Post::findOrFail($postId);

        $existingReaction = Reaction::where('user_id', auth()->id())
            ->where('post_id', $post->id)
            ->first();

        if ($existingReaction) {
            if ($existingReaction->reaction === $validated['reaction']) {
                $existingReaction->delete();
            } else {
                $existingReaction->update(['reaction' => $validated['reaction']]);
            }
        } else {
            Reaction::create([
                'user_id' => auth()->id(),
                'post_id' => $post->id,
                'reaction' => $validated['reaction'],
            ]);
        }

        // Get the updated user reaction
        $userReaction = Reaction::where('user_id', auth()->id())
            ->where('post_id', $post->id)
            ->first();

        $reactionEmojis = [
            'like' => '👍',
            'love' => '❤️',
            'wow' => '😲',
            'haha' => '😂',
            'sad' => '😢',
            'grr'  => '😡',
        ];

        return view('partials.reaction', [
            'post' => $post,
            'userReaction' => $userReaction,
            'reactionEmojis' => $reactionEmojis
        ]);
    }


    /**
     * Remove a reaction for a post.
     */
    public function destroy($postId)
    {
        $post = Post::findOrFail($postId);

        $reaction = Reaction::where('user_id', auth()->id())
            ->where('post_id', $post->id)
            ->first();

        if ($reaction) {
            $reaction->delete();
        }

        return redirect()->back()->with('success', 'Reaction removed successfully!');
    }
}
