<?php

namespace App\Services\Repositories\Users;

use App\Models\Users\Professor;

interface IProfessorRepository
{
    public function findByLoginAndPassword($login, $plainPassword): ?Professor;
}