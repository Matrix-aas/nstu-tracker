<?php

namespace App\Services\Users;

use App\Models\Users\Admin;
use Illuminate\Auth\Access\AuthorizationException;

interface IAdminService
{
    public function findByLoginAndPassword($login, $plainPassword): ?Admin;

    /**
     * @param $login
     * @param $plainPassword
     * @param null $ip
     * @param bool $remeber
     * @return string
     * @throws AuthorizationException
     * @throws \RuntimeException
     */
    public function authAdmin($login, $plainPassword, $ip = null, $remeber = false): string;
}