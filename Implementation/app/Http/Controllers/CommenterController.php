<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Services\CommenterService;
use Illuminate\Http\Request;

class CommenterController extends Controller
{
    protected CommenterService $commenterService;

    public function __construct(CommenterService $commenterService)
    {
        $this->commenterService = $commenterService;
    }

    public function index()
    {
        $comments = $this->commenterService->all();

        return view('comments.index', compact('comments'));
    }

    public function store(Request $request, $post_id)
    {
        $data = $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $comment = $this->commenterService->create($data, $post_id);

        if (!$comment instanceof Comment) {
            return redirect()->back()->with('error', 'Failed to create comment');
        }

        return redirect()->back()->with('success', 'Comment created successfully');
    }

    public function show(int $id)
    {
        $comment = $this->commenterService->find($id);

        if (!$comment instanceof Comment) {
            return redirect()->back()->with('error', 'Comment not found');
        }

        return view('comments.show', compact('comment'));
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'content' => ['required', 'string'],
            'image' => ['required', 'string'],
        ]);

        $result = $this->commenterService->update($data, $id);

        if ($result <= 0) {
            return redirect()->back()->with('error', 'Failed to update comment');
        }

        return redirect()->back()->with('success', 'Comment updated successfully');
    }

    public function destroy(int $id)
    {
        $this->commenterService->delete($id);

        return redirect()->back()->with('success', 'Comment deleted successfully');
    }
}
