<?php

namespace App\Services\Repositories;

use App\Models\Discipline;
use App\Models\Users\Professor;

class ProfessorDisciplineRepository implements IProfessorDisciplineRepository
{
    public function attachDiscipline(int $professorId, int $disciplineId): bool
    {
        /** @var Professor $professor */
        $professor = Professor::query()->find($professorId);
        if (!$professor)
            return false;
        try {
            $professor->disciplines()->attach($disciplineId);
        } catch (\Exception $exception) {
            return false;
        }
        return true;
    }

    public function attachProfessor(int $disciplineId, int $professorId): bool
    {
        /** @var Discipline $discipline */
        $discipline = Discipline::query()->find($disciplineId);
        if (!$discipline)
            return false;
        try {
            $discipline->professors()->attach($professorId);
        } catch (\Exception $exception) {
            return false;
        }
        return true;
    }

    public function detachDiscipline(int $professorId, int $disciplineId): bool
    {
        /** @var Professor $professor */
        $professor = Professor::query()->find($professorId);
        if (!$professor)
            return false;
        try {
            $professor->disciplines()->detach($disciplineId);
        } catch (\Exception $exception) {
            return false;
        }
        return true;
    }

    public function detachProfessor(int $disciplineId, int $professorId): bool
    {
        /** @var Discipline $discipline */
        $discipline = Discipline::query()->find($disciplineId);
        if (!$discipline)
            return false;
        try {
            $discipline->professors()->detach($professorId);
        } catch (\Exception $exception) {
            return false;
        }
        return true;
    }
}