<?php

namespace App\Http\Controllers;

use App\Services\IDisciplineService;

class Discipline extends AbstractCrudController
{
    public function __construct(IDisciplineService $disciplineService)
    {
        parent::__construct($disciplineService);
    }
}
