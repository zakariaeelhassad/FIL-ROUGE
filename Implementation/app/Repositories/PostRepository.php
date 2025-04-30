<?php

namespace App\Repositories;

use App\Models\Post;
use App\Repositories\interface\RepositoryInterface;

class PostRepository implements RepositoryInterface
{
    public function all()
    {
        return Post::all();
    }

    public function create(array $data)
    {
        return Post::create($data);
    }

    public function update(array $data, int $id)
    {
        $post = Post::findOrFail($id);

        return $post->update($data);
    }

    public function delete(int $id)
    {
        $post = Post::findOrFail($id);

        return $post->delete();
    }

    public function find(int $id)
    {
        return Post::find($id);
    }

    public function paginate($perPage = 2)
    {
        return Post::paginate($perPage); 
    }
}