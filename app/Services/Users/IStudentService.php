<?php

namespace App\Services\Users;

use App\Models\Users\Student;
use App\Services\IAbstractCrudService;
use Illuminate\Auth\Access\AuthorizationException;

interface IStudentService extends IAbstractCrudService
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