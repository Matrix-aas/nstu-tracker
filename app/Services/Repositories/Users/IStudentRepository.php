<?php

namespace App\Services\Repositories\Users;

use App\Models\Users\Student;
use App\Services\Repositories\IAbstractCrudRepository;

interface IStudentRepository extends IAbstractCrudRepository
{
    public function findByLoginAndPassword($login, $plainPassword): ?Student;
}