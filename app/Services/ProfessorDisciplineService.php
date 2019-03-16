<?php

namespace App\Services;

use App\Services\Repositories\IProfessorDisciplineRepository;

class ProfessorDisciplineService implements IProfessorDisciplineService
{
    private $repository;

    public function __construct(IProfessorDisciplineRepository $repository)
    {
        $this->repository = $repository;
    }

    public function attachDiscipline(int $professorId, int $disciplineId): bool
    {
        return $this->repository->attachDiscipline($professorId, $disciplineId);
    }

    public function attachProfessor(int $disciplineId, int $professorId): bool
    {
        return $this->repository->attachProfessor($professorId, $disciplineId);
    }

    public function detachDiscipline(int $professorId, int $disciplineId): bool
    {
        return $this->repository->detachDiscipline($professorId, $disciplineId);
    }

    public function detachProfessor(int $disciplineId, int $professorId): bool
    {
        return $this->repository->detachProfessor($professorId, $disciplineId);
    }
}