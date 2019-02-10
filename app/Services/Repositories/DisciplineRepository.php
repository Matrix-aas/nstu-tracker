<?php

namespace App\Services\Repositories;

use App\Models\Discipline;

class DisciplineRepository extends AbstractCrudRepository implements IDisciplineRepository
{
    protected $modelClass = Discipline::class;
}