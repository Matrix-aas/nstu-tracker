<?php

namespace App\Services\Repositories;

use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class VisitRepository implements IVisitRepository
{
    public function findById(int $id): ?Visit
    {
        return Visit::query()->find($id);
    }

    public function findAll(): Collection
    {
        return Visit::all();
    }

    public function mark(int $studentId, int $lessonId, Carbon $date): ?Visit
    {
        $visit = new Visit([
            'lesson_id' => $lessonId,
            'student_id' => $studentId,
            'created_at' => $date,
            'updated_at' => $date
        ]);
        return $visit->save() ? $visit : null;
    }

    public function unmark(int $id): bool
    {
        $visit = $this->findById($id);
        if (!$visit)
            return false;

        try {
            return $visit->delete() === true;
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function findByStudent(int $studentId): Collection
    {
        return Visit::query()->where('student_id', $studentId)->get();
    }

    public function findByLesson(int $lessonId): Collection
    {
        return Visit::query()->where('lesson_id', $lessonId)->get();
    }

    public function findByDate(Carbon $date): Collection
    {
        return Visit::query()->whereDate('created_at', $date)->get();
    }

    public function findByStudentAndLesson(int $studentId, int $lessonId): Collection
    {
        return Visit::query()->where('student_id', $studentId)->where('lesson_id', $lessonId)->get();
    }

    public function findByStudentAndDate(int $studentId, Carbon $date): Collection
    {
        return Visit::query()->where('student_id', $studentId)->whereDate('created_at', $date)->get();
    }

    public function findByLessonAndDate(int $lessonId, Carbon $date): Collection
    {
        return Visit::query()->where('lesson_id', $lessonId)->whereDate('created_at', $date)->get();
    }

    public function findByStudentAndLessonAndDate(int $studentId, int $lessonId, Carbon $date): ?Visit
    {
        return Visit::query()->where('student_id', $studentId)->where('lesson_id', $lessonId)->whereDate('created_at', $date)->first();
    }
}