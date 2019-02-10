<?php

namespace App\Services\Repositories\Users;

use App\Models\Users\Professor;
use Illuminate\Support\Facades\Hash;

class ProfessorRepository implements IProfessorRepository
{
    public function findByLoginAndPassword($login, $plainPassword): ?Professor
    {
        /** @var Professor $professor */
        $professor = Professor::query()->where("login", $login)->first();
        if ($professor && Hash::check($plainPassword, $professor->password))
            return $professor;
        return null;
    }
}