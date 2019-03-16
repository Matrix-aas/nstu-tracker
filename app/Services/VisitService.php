<?php

namespace App\Services;

use App\Models\Visit;
use App\Services\Repositories\IVisitRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class VisitService implements IVisitService
{
    private $repository;

    public function __construct(IVisitRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findById(int $id): ?Visit
    {
        return $this->repository->findById($id);
    }

    public function mark(int $studentId, int $lessonId, Carbon $date): ?Visit
    {
        return $this->repository->mark($studentId, $lessonId, $date);
    }

    public function unmark(int $id): bool
    {
        return $this->repository->unmark($id);
    }

    public function findByStudent(int $studentId): Collection
    {
        return $this->repository->findByStudent($studentId);
    }

    public function findByLesson(int $lessonId): Collection
    {
        return $this->repository->findByLesson($lessonId);
    }

    public function findByDate(Carbon $date): Collection
    {
        return $this->repository->findByDate($date);
    }

    public function findByStudentAndLesson(int $studentId, int $lessonId): Collection
    {
        return $this->repository->findByStudentAndLesson($studentId, $lessonId);
    }

    public function findByStudentAndDate(int $studentId, Carbon $date): Collection
    {
        return $this->repository->findByStudentAndDate($studentId, $date);
    }

    public function findByLessonAndDate(int $lessonId, Carbon $date): Collection
    {
        return $this->repository->findByLessonAndDate($lessonId, $date);
    }

    public function findByStudentAndLessonAndDate(int $studentId, int $lessonId, Carbon $date): ?Visit
    {
        return $this->repository->findByStudentAndLessonAndDate($studentId, $lessonId, $date);
    }
}