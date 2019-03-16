<?php

namespace App\Services\Repositories;

use App\Models\Discipline;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class DisciplineRepository extends AbstractCrudRepository implements IDisciplineRepository
{
    protected $modelClass = Discipline::class;

    public function findByProfessorId(int $professorId): Collection
    {
        return Discipline::query()->whereHas('professors', function (Builder $query) use ($professorId) {
            $query->where('id', $professorId);
        })->get();
    }
}