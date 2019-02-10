<?php

namespace App\Services\Users;

use App\Models\Users\Professor;
use Illuminate\Auth\Access\AuthorizationException;

interface IProfessorService
{
    public function findByLoginAndPassword($login, $plainPassword): ?Professor;

    /**
     * @param $login
     * @param $plainPassword
     * @param null $ip
     * @param bool $remeber
     * @return string
     * @throws AuthorizationException
     * @throws \RuntimeException
     */
    public function auth($login, $plainPassword, $ip = null, $remeber = false): string;
}