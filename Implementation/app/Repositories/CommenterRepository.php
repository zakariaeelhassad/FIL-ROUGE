<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Repositories\interface\RepositoryInterface;

class CommenterRepository implements RepositoryInterface
{
    public function all()
    {
        return Comment::all();
    }

    public function create(array $data)
    {
        return Comment::create($data);
    }

    public function update(array $data, int $id)
    {
        $comment = Comment::findOrFail($id);

        return $comment->update($data);
    }

    public function delete(int $id)
    {
        $comment = Comment::findOrFail($id);

        return $comment->delete();
    }

    public function find(int $id)
    {
        return Comment::find($id);
    }
}