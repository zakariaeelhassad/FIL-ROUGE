<?php

namespace App\Services;

use App\Repositories\interface\RepositoryInterface;
use App\Repositories\PostRepository;

class PostService
{
    private PostRepository $repository;

    public function __construct(PostRepository $repository) {
        $this->repository = $repository;
    }

    public function create(array $data)
    {
        $data['user_id'] = auth()->id();
        return $this->repository->create($data);
    }

    public function update(array $data, int $id)
    {
        return $this->repository->update($data, $id);
    }

    public function delete(int $id)
    {
        $this->repository->delete($id);
    }

    public function all()
    {
         return $this->repository->all()->load('user');
    }

    public function find(int $id)
    {
        return $this->repository->find($id);
    }

    public function paginate()
    {
        return $this->repository->paginate(2); 
    }
}