<?php
namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentReply;
use Illuminate\Http\Request;

class CommentReplyController extends Controller
{
    public function store(Comment $comment, Request $request)
    {
        $validated = $request->validate([
            "content" => 'required|string|min:1',
        ]);

        $content = $request->input('content');
        $user_id = auth()->id();

        if ($validated) {
            $comment->replies()->create([
                "content" => $content,
                'user_id' => $user_id,
            ]);
        }

        return back()->with('success', 'Votre réponse a été ajoutée.');
    }
}