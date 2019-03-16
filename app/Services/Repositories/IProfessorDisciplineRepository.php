<?php

namespace App\Services\Repositories;

interface IProfessorDisciplineRepository
{
    public function attachDiscipline(int $professorId, int $disciplineId): bool;

    public function attachProfessor(int $disciplineId, int $professorId): bool;

    public function detachDiscipline(int $professorId, int $disciplineId): bool;

    public function detachProfessor(int $disciplineId, int $professorId): bool;
}