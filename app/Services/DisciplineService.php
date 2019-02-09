<?php

namespace App\Services;

use App\Services\Repositories\IDisciplineRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class DisciplineService extends EmptyCrudService implements IDisciplineService
{
    private $disciplineRepository;

    public function __construct(IDisciplineRepository $disciplineRepository)
    {
        $this->disciplineRepository = $disciplineRepository;
    }

    public function findAll(): Collection
    {
        return $this->disciplineRepository->findAll();
    }

    public function findById(int $id): Model
    {
        return $this->disciplineRepository->findById($id);
    }

    public function delete(int $id): bool
    {
        return $this->disciplineRepository->delete($this->findById($id));
    }
}