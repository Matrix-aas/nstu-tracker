<?php

namespace App\Services;

use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

interface IVisitService
{
    public function findById(int $id): ?Visit;

    public function findAll(): Collection;

    /**
     * @param int|array $studentIds
     * @param int $lessonId
     * @param Carbon $date
     * @return Visit|Visit[]
     */
    public function mark($studentIds, int $lessonId, Carbon $date);

    public function unmark(int $id): bool;

    public function findByStudent(int $studentId): Collection;

    public function findByLesson(int $lessonId): Collection;

    public function findByDate(Carbon $date): Collection;

    public function findByStudentAndLesson(int $studentId, int $lessonId): Collection;

    public function findByStudentAndDate(int $studentId, Carbon $date): Collection;

    public function findByLessonAndDate(int $lessonId, Carbon $date): Collection;

    public function findByStudentAndLessonAndDate(int $studentId, int $lessonId, Carbon $date): ?Visit;

    public function find(int $studentId = null, int $lessonId = null, Carbon $date = null);
}