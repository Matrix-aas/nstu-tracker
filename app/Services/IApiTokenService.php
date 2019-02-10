<?php


namespace App\Services;


use App\Models\ApiToken;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Collection;

interface IApiTokenService
{
    public function findToken($token, $ip): ?ApiToken;

    public function findTokenAndAuth($token, $ip = null): ?User;

    public function findAllTokensByUser(User $user): Collection;

    public function createNewTokenForUser(User $user, $ip = null, $remember = false): ?ApiToken;

    public function touch(ApiToken $token): bool;

    public function delete(ApiToken $token): bool;
}