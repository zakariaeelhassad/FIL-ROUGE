<?php

namespace App\Services;

use App\Repositories\TitreRepository;

class TitreService
{
    private TitreRepository $repository;

    public function __construct(TitreRepository $repository) {
        $this->repository = $repository;
    }

    public function create(array $data)
    {
        $clubAdminProfile = \App\Models\ClubAdminProfile::where('user_id', auth()->id())->first();

        if (!$clubAdminProfile) {
            throw new \Exception('Aucun profil club admin trouvé pour cet utilisateur.');
        }

        $data['club_admin_profile_id'] = $clubAdminProfile->id;
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
}