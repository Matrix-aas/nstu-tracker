<?php

namespace App\Services;

interface IProfessorDisciplineService
{
    public function attachDiscipline(int $professorId, int $disciplineId): bool;

    public function attachProfessor(int $disciplineId, int $professorId): bool;

    public function detachDiscipline(int $professorId, int $disciplineId): bool;

    public function detachProfessor(int $disciplineId, int $professorId): bool;
}