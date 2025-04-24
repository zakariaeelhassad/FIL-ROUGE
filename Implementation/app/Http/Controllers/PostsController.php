<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\Post;
use App\Models\Reaction;
use Illuminate\Http\Request;
use App\Services\PostService;

class PostsController extends Controller
{
    protected PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->middleware('auth'); 
        $this->postService = $postService;
    }

    public function index()
    {
        $userId = auth()->id();
        
        $followingIds = Follow::where('follower_id', $userId)
            ->pluck('following_id')
            ->toArray();
        
        $followingIds[] = $userId;
        
        $posts = Post::whereIn('user_id', $followingIds)
                    ->with(['user', 'media', 'comments', 'reactions' => function($query) use ($userId) {
                        $query->where('user_id', $userId);
                    }])
                    ->latest()
                    ->get();

        return view('pages.home', compact('posts'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'content' => ['required', 'string'],
            'media.*' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,mp4,mov,avi', 'max:51200'],
        ]);

        $post = new Post();
        $post->user_id = auth()->id();
        $post->content = $data['content'];
        $post->save();

        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                if ($file->getSize() > 200 * 1024 * 1024) {
                    return back()
                        ->withErrors(['media' => 'الملف كبير بزاف. الحد الأقصى هو 200MB.'])
                        ->withInput(); 
                }

                $path = $file->store('posts', 'public');
                $mimeType = $file->getMimeType();
                $type = str_contains($mimeType, 'video') ? 'video' : 'image';

                $post->media()->create([
                    'path' => $path,
                    'type' => $type
                ]);
            }
        }

        return redirect()->route('posts.index')->with('success', 'Post créé avec succès');
    }

    public function show(int $id)
    {
        $post = $this->postService->find($id);

        if (!$post instanceof Post) {
            return redirect()->back()->with('error', 'Post non trouvé');
        }

        $user = $post->user;

        return view('components.profil.activite', compact('post' , 'user'));
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'content' => ['required', 'string'],
            'media.*' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,mp4,mov,avi', 'max:51200'],
            'keep_media' => ['nullable', 'array'],
            'remove_media' => ['nullable', 'boolean'],
        ]);

        $post = Post::findOrFail($id);
        
        if ($post->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Action non autorisée');
        }

        $post->content = $data['content'];
        $post->save();

        if ($request->has('remove_media')) {
            $post->media()->delete();
        } elseif ($request->has('keep_media')) {
            $post->media()->whereNotIn('id', $request->keep_media ?? [])->delete();
        }

        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $path = $file->store('posts', 'public');
                $type = str_contains($file->getMimeType(), 'video') ? 'video' : 'image';
                $post->media()->create(['path' => $path, 'type' => $type]);
            }
        }

        return redirect()->back()->with('success', 'Post mis à jour avec succès');
    }

    public function destroy(int $id)
    {
        $result = $this->postService->delete($id);

        return redirect()->route('posts.index')->with('success', 'Post supprimé avec succès');
    }
}
