<?php

namespace App\Services;

use App\DTO\DisciplineDTO;
use App\Models\Discipline;
use App\Services\Repositories\IDisciplineRepository;
use Illuminate\Database\Eloquent\Collection;

class DisciplineService extends AbstractCrudService implements IDisciplineService
{
    protected $modelClass = Discipline::class;
    protected $dtoClass = DisciplineDTO::class;

    public function __construct(IDisciplineRepository $disciplineRepository)
    {
        parent::__construct($disciplineRepository);
    }

    public function findByProfessorId(int $professorId): Collection
    {
        /** @var IDisciplineRepository $repository */
        $repository = $this->crudRepository;
        return $repository->findByProfessorId($professorId);
    }
}