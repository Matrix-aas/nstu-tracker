<?php

namespace App\Services\Repositories\Users;

use App\Models\Users\Admin;
use Illuminate\Support\Facades\Hash;

class AdminRepository implements IAdminRepository
{
    public function findByLoginAndPassword($login, $plainPassword): ?Admin
    {
        /** @var Admin $admin */
        $admin = Admin::query()->where("login", $login)->first();
        if ($admin && Hash::check($plainPassword, $admin->password))
            return $admin;
        return null;
    }
}