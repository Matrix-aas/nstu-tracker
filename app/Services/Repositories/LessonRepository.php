<?php


namespace App\Services\Repositories;


use App\Models\Lesson;

class LessonRepository extends AbstractRepository implements ILessonRepository
{
    public $modelClass = Lesson::class;
}