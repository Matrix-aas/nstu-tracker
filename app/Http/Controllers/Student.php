<?php

namespace App\Http\Controllers;

use App\Services\Users\IStudentService;

class Student extends AbstractCrudController
{
    public function __construct(IStudentService $studentService)
    {
        parent::__construct($studentService);
    }
}
