<?php

namespace App\Services\Users;

use App\Services\EmptyCrudService;
use App\Services\Repositories\Users\IProfessorRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ProfessorService extends EmptyCrudService implements IAdminService
{
    private $professorRepository;

    public function __construct(IProfessorRepository $professorRepository)
    {
        $this->professorRepository = $professorRepository;
    }

    public function findAll(): Collection
    {
        return $this->professorRepository->findAll();
    }

    public function findById(int $id): Model
    {
        return $this->professorRepository->findById($id);
    }

    public function delete(int $id): bool
    {
        return $this->professorRepository->delete($this->findById($id));
    }
}