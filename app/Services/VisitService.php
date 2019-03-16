<?php

namespace App\Services;

use App\Models\Lesson;
use App\Models\Visit;
use App\Services\Repositories\IVisitRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

    public function findAll(): Collection
    {
        return $this->repository->findAll();
    }

    public function mark($studentIds, int $lessonId, Carbon $date)
    {
        if (!Lesson::query()->whereKey($lessonId)->exists())
            throw new NotFoundHttpException("Lesson with id:$lessonId not found");
        if (is_numeric($studentIds))
            return $this->repository->mark($studentIds, $lessonId, $date);
        else if (!is_array($studentIds))
            throw new \InvalidArgumentException("\$studentIds must be array or integer!");
        $visits = [];
        foreach ($studentIds as $studentId) {
            $visit = $this->repository->mark($studentId, $lessonId, $date);
            if ($visit)
                $visits[] = $visit;
        }
        return $visits;
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

    public function find(int $studentId = null, int $lessonId = null, Carbon $date = null)
    {
        if (empty($studentId) && empty($lessonId) && empty($date)) {
            return $this->findAll();
        } else if (!empty($studentId) && !empty($lessonId) && !empty($date)) {
            return $this->repository->findByStudentAndLessonAndDate($studentId, $lessonId, $date);
        } else if (!empty($studentId) && !empty($lessonId)) {
            return $this->repository->findByStudentAndLesson($studentId, $lessonId);
        } else if (!empty($studentId) && !empty($date)) {
            return $this->repository->findByStudentAndDate($studentId, $date);
        } else if (!empty($lessonId) && !empty($date)) {
            return $this->repository->findByLessonAndDate($lessonId, $date);
        } else if (!empty($studentId)) {
            return $this->repository->findByStudent($studentId);
        } else if (!empty($lessonId)) {
            return $this->repository->findByLesson($lessonId);
        } else if (!empty($date)) {
            return $this->repository->findByDate($date);
        }
        throw new \RuntimeException("WOW!");
    }
}