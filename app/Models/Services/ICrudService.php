<?php

namespace App\Models\Services;

use Illuminate\Database\Eloquent\Collection;

interface ICrudService
{
    public function findAll(): Collection;


}