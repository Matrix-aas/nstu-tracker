<?php

namespace App\Services;

use App\DTO\LessonDTO;
use App\Models\Lesson;
use App\Services\Repositories\ILessonRepository;

class LessonService extends AbstractCrudService implements ILessonService
{
    protected $modelClass = Lesson::class;
    protected $dtoClass = LessonDTO::class;

    public function __construct(ILessonRepository $lessonRepository)
    {
        parent::__construct($lessonRepository);
    }
}