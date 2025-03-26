<?php

namespace App\Repositories;

use App\Models\Experience;
use App\Repositories\interface\RepositoryInterface;

class ExperienceRepository implements RepositoryInterface
{
    public function all()
    {
        return Experience::all();
    }

    public function create(array $data)
    {
        return Experience::create($data);
    }

    public function update(array $data, int $id)
    {
        $esperience = Experience::findOrFail($id);

        return $esperience->update($data);
    }

    public function delete(int $id)
    {
        $esperience = Experience::findOrFail($id);

        return $esperience->delete();
    }

    public function find(int $id)
    {
        return Experience::find($id);
    }
}