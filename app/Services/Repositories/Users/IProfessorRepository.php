<?php

namespace App\Services\Repositories\Users;

use App\Models\Users\Professor;
use App\Services\Repositories\IAbstractCrudRepository;

interface IProfessorRepository extends IAbstractCrudRepository
{
    public function findByLoginAndPassword($login, $plainPassword): ?Professor;
}