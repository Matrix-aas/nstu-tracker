<?php

namespace App\Services\Repositories;

use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

interface IVisitRepository
{
    public function findById(int $id): ?Visit;

    public function findAll(): Collection;

    public function mark(int $studentId, int $lessonId, Carbon $date): ?Visit;

    public function unmark(int $id): bool;

    public function findByStudent(int $studentId): Collection;

    public function findByLesson(int $lessonId): Collection;

    public function findByDate(Carbon $date): Collection;

    public function findByStudentAndLesson(int $studentId, int $lessonId): Collection;

    public function findByStudentAndDate(int $studentId, Carbon $date): Collection;

    public function findByLessonAndDate(int $lessonId, Carbon $date): Collection;

    public function findByStudentAndLessonAndDate(int $studentId, int $lessonId, Carbon $date): ?Visit;
}