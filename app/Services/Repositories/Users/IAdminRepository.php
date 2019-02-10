<?php

namespace App\Services\Repositories\Users;

use App\Models\Users\Admin;

interface IAdminRepository
{
    public function findByLoginAndPassword($login, $plainPassword): ?Admin;
}