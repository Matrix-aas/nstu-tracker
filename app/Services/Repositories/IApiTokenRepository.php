<?php

namespace App\Services\Repositories;

use App\Models\ApiToken;
use Illuminate\Database\Eloquent\Collection;

interface IApiTokenRepository
{
    public function find($token, $ip): ?ApiToken;

    public function findAllByUserIdAndRole($user_id, $role): Collection;

    public function save(ApiToken $token): bool;

    public function touch(ApiToken $token): bool;

    public function delete(ApiToken $token): bool;
}