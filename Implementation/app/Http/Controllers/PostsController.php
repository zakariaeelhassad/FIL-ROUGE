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
        $this->postService = $postService;
    }

    public function index()
    {
        $posts = $this->postService->all();

        return response()->json([
            'status' => 'success',
            'data' => $posts
        ], 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'content' => ['required', 'string'],
            'image' => ['required', 'string'],

        ]); 

        $post = $this->postService->create($data);

        if (!$post instanceof Post) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create post'
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'data' => $post,
        ], 201);
    }


    public function show(int $id)
    {
        $post = $this->postService->find($id);

        if (!$post instanceof Post) {
            return response()->json([
                'status' => 'error',
                'message' => 'Post not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $post
        ], 200);
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'content' => ['required', 'string'],
            'image' => ['required', 'string']
        ]);

        $result = $this->postService->update($data, $id);

        if ($result <= 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update Post'
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Post updated successfully'
        ],200);
    }

    public function destroy(int $id)
    {
        $result = $this->postService->delete($id);

        // if (!is_bool($result)) {
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'Failed to delete Post'
        //     ], 500);
        // }

        return response()->json([
            'status' => 'success',
            'message' => 'Post deleted successfully'
        ], 200);
    }
}
