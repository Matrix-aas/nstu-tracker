<?php

namespace App\Http\Controllers;

use App\Services\Users\IProfessorService;

class Professor extends AbstractCrudController
{
    public function __construct(IProfessorService $professorService)
    {
        parent::__construct($professorService);
    }
}
