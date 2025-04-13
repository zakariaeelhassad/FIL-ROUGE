<?php

namespace App\Repositories;

use App\Models\Titre;
use App\Repositories\interface\RepositoryInterface;

class TitreRepository implements RepositoryInterface
{
    public function all()
    {
        return Titre::all();
    }

    public function create(array $data)
    {
        return Titre::create($data);
    }

    public function update(array $data, int $id)
    {
        $post = Titre::findOrFail($id);

        return $post->update($data);
    }

    public function delete(int $id)
    {
        $post = Titre::findOrFail($id);

        return $post->delete();
    }

    public function find(int $id)
    {
        return Titre::find($id);
    }
}