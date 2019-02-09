<?php

namespace App\Services;

use App\Services\Repositories\ILessonRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class LessonService extends EmptyCrudService implements ILessonService
{
    private $lessonRepository;

    public function __construct(ILessonRepository $lessonRepository)
    {
        $this->lessonRepository = $lessonRepository;
    }

    public function findAll(): Collection
    {
        return $this->lessonRepository->findAll();
    }

    public function findById(int $id): Model
    {
        return $this->lessonRepository->findById($id);
    }

    public function delete(int $id): bool
    {
        return $this->lessonRepository->delete($this->findById($id));
    }
}