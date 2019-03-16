<?php

namespace App\Services\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface IDisciplineRepository extends IAbstractCrudRepository
{
    public function findByProfessorId(int $professorId): Collection;
}