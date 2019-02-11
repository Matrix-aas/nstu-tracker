<?php

namespace App\Services\Repositories\Users;

use App\Models\Users\Professor;
use App\Services\Repositories\AbstractCrudRepository;
use Illuminate\Support\Facades\Hash;

class ProfessorRepository extends AbstractCrudRepository implements IProfessorRepository
{
    protected $modelClass = Professor::class;

    public function findByLoginAndPassword($login, $plainPassword): ?Professor
    {
        /** @var Professor $professor */
        $professor = Professor::query()->where("login", $login)->first();
        if ($professor && Hash::check($plainPassword, $professor->password))
            return $professor;
        return null;
    }
}