<?php

namespace App\Http\Controllers;

use App\Services\ILessonService;

class Lesson extends AbstractCrudController
{
    public function __construct(ILessonService $lessonService)
    {
        parent::__construct($lessonService);
    }
}
