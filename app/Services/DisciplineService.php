<?php

namespace App\Services;

use App\DTO\DisciplineDTO;
use App\Models\Discipline;
use App\Services\Repositories\IDisciplineRepository;

class DisciplineService extends AbstractCrudService implements IDisciplineService
{
    protected $modelClass = Discipline::class;
    protected $dtoClass = DisciplineDTO::class;

    public function __construct(IDisciplineRepository $disciplineRepository)
    {
        parent::__construct($disciplineRepository);
    }
}