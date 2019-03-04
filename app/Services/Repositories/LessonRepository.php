<?php

namespace App\Services\Repositories;

use App\Models\Lesson;

class LessonRepository extends AbstractCrudRepository implements ILessonRepository
{
    protected $modelClass = Lesson::class;
}