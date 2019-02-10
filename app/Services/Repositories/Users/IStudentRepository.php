<?php

namespace App\Services\Repositories\Users;

use App\Models\Users\Student;

interface IStudentRepository
{
    public function findByLoginAndPassword($login, $plainPassword): ?Student;
}