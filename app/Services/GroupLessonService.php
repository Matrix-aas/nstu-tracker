<?php


namespace App\Services;


use App\Services\Repositories\IGroupLessonRepository;

class GroupLessonService implements IGroupLessonService
{
    private $repository;

    public function __construct(IGroupLessonRepository $repository)
    {
        $this->repository = $repository;
    }

    public function attachLesson(int $groupId, int $lessonId): bool
    {
        return $this->repository->attachLesson($groupId, $lessonId);
    }

    public function attachGroup(int $lessonId, int $groupId): bool
    {
        return $this->repository->attachGroup($groupId, $lessonId);
    }

    public function detachLesson(int $groupId, int $lessonId): bool
    {
        return $this->repository->detachLesson($groupId, $lessonId);
    }

    public function detachGroup(int $lessonId, int $groupId): bool
    {
        return $this->repository->detachGroup($groupId, $lessonId);
    }
}