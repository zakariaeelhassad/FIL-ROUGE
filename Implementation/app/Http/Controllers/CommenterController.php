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

        return response()->json([
            'status' => 'success',
            'data' => $comments
        ], 200);
    }

    public function store(Request $request , $post_id)
    {
        $data = $request->validate([
           'content' => 'required|string|max:500',
        ]); 

        $comment = $this->commenterService->create($data , $post_id);

        if (!$comment instanceof Comment) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create comments'
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'data' => $comment,
        ], 201);
    }


    public function show(int $id)
    {
        $comment = $this->commenterService->find($id);

        if (!$comment instanceof Comment) {
            return response()->json([
                'status' => 'error',
                'message' => 'Post not comments'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $comment
        ], 200);
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'content' => ['required', 'string'],
            'image' => ['required', 'string']
        ]);

        $result = $this->commenterService->update($data, $id);

        if ($result <= 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update comments'
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'comments updated successfully'
        ],200);
    }

    public function destroy(int $id)
    {
        $result = $this->commenterService->delete($id);

        // if (!is_bool($result)) {
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'Failed to delete comments'
        //     ], 500);
        // }

        return response()->json([
            'status' => 'success',
            'message' => 'comment deleted successfully'
        ], 200);
    }
}
