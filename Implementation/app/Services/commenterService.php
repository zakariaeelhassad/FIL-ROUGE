<?php

namespace App\Services;

use App\Models\Post;
use App\Repositories\CommenterRepository;

class CommenterService
{
    private CommenterRepository $repository;

    public function __construct(CommenterRepository $repository) {
        $this->repository = $repository;
    }

    public function create(array $data , $post_id)
    {
        $post = Post::find($post_id);
        if (!$post) {
            return response()->json([
                'message' => 'Salle non trouvée.'
            ], 404);
        }
        $data['post_id'] = $post_id; 
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
        return $this->repository->all();
    }

    public function find(int $id)
    {
        return $this->repository->find($id);
    }
}