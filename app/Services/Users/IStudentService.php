<?php

namespace App\Services\Users;

use App\Models\Users\Student;
use Illuminate\Auth\Access\AuthorizationException;

interface IStudentService
{
    public function findByLoginAndPassword($login, $plainPassword): ?Student;

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