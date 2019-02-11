<?php

namespace App\Services\Repositories\Users;

use App\Models\Users\Student;
use App\Services\Repositories\AbstractCrudRepository;
use Illuminate\Support\Facades\Hash;

class StudentRepository extends AbstractCrudRepository implements IStudentRepository
{
    protected $modelClass = Student::class;

    public function findByLoginAndPassword($login, $plainPassword): ?Student
    {
        /** @var Student $student */
        $student = Student::query()->where("login", $login)->first();
        if ($student && Hash::check($plainPassword, $student->password))
            return $student;
        return null;
    }
}