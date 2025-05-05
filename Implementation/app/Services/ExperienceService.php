<?php

namespace App\Services;

use App\Repositories\ExperienceRepository;

class ExperienceService
{
    private ExperienceRepository $repository;

    public function __construct(ExperienceRepository $repository) {
        $this->repository = $repository;
    }

    public function create(array $data)
    {
        $joueurProfile = \App\Models\JoueurProfile::where('user_id', auth()->id())->first();

        if (!$joueurProfile) {
            throw new \Exception('Aucun profil club admin trouvé pour cet utilisateur.');
        }

        $data['joueur_profile_id'] = $joueurProfile->id;
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