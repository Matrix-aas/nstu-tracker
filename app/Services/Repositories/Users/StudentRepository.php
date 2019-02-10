<?php

namespace App\Services\Repositories\Users;

use App\Models\Users\Student;
use Illuminate\Support\Facades\Hash;

class StudentRepository implements IStudentRepository
{
    public function findByLoginAndPassword($login, $plainPassword): ?Student
    {
        /** @var Student $student */
        $student = Student::query()->where("login", $login)->first();
        if ($student && Hash::check($plainPassword, $student->password))
            return $student;
        return null;
    }
}