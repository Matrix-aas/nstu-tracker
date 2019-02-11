<?php

namespace App\Services\Repositories;

use App\Models\ApiToken;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ApiTokenRepository implements IApiTokenRepository
{
    public $modelClass = ApiToken::class;

    public function find($token, $ip = null): ?ApiToken
    {
        $query = ApiToken::query()->where("token", $token);
        if ($ip) {
            $query->where(function (Builder $query) use ($ip) {
                $query->where("ip", $ip)->orWhereNull("ip");
            });
        }
        /** @var ApiToken $token */
        $token = $query->first();
        return $token;
    }

    public function findAllByUserIdAndRole($user_id, $role): Collection
    {
        return ApiToken::query()->where(["user_id" => $user_id, "user_role" => $role])->get();
    }

    public function save(ApiToken $token): bool
    {
        return $token->save();
    }

    public function touch(ApiToken $token): bool
    {
        return $token->touch();
    }

    public function delete(ApiToken $token): bool
    {
        try {
            return $token->delete() === true;
        } catch (\Exception $exception) {
            return false;
        }
    }
}