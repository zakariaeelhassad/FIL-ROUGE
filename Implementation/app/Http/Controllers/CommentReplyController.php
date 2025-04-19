<?php
namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentReply;
use Illuminate\Http\Request;

class CommentReplyController extends Controller
{
    public function store(Request $request, $comment_id)
{
    $validated = $request->validate([
        'content' => 'required|string|min:1',
    ]);

    $content = $request->input('content');
    $user_id = auth()->id();

    $comment = Comment::find($comment_id);

    if ($comment) {
        $reply = $comment->replies()->create([
            'content' => $content,
            'user_id' => $user_id,
        ]);

        return response()->view('partials.replies', ['reply' => $reply]);
    }

    return response()->json(['error' => 'Comment not found'], 404);
}


    
    
}