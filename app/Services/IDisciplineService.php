<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;

interface IDisciplineService extends IAbstractCrudService
{
    public function findByProfessorId(int $professorId): Collection;
}