<?php

namespace App\Services\Users;

interface IAuthService
{
    public function getAllTokensData();

    public function logout(): void;
}