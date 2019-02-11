<?php

namespace App\Services\Users;

use App\DTO\AdminDTO;
use App\Models\Users\Admin;
use Illuminate\Auth\Access\AuthorizationException;

interface IAdminService
{
    public function findByLoginAndPassword($login, $plainPassword): ?Admin;

    public function save(AdminDTO $dto): bool;

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