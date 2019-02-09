<?php

namespace App\Services\Repositories;

use App\Models\Visit;

class VisitRepository extends AbstractRepository implements IVisitRepository
{
    public $modelClass = Visit::class;
}