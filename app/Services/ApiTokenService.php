<?php

namespace App\Services;

use App\DTO\ApiTokenDTO;
use App\Models\ApiToken;
use App\Models\Users\User;
use App\Services\Repositories\ApiTokenRepository;
use Illuminate\Database\Eloquent\Collection;

class ApiTokenService implements IApiTokenService
{
    private $apiTokenRepository;

    public function __construct(ApiTokenRepository $apiTokenRepository)
    {
        $this->apiTokenRepository = $apiTokenRepository;
    }

    public function findToken($token, $ip = null): ?ApiToken
    {
        return $this->apiTokenRepository->find($token, $ip);
    }

    public function findTokenAndAuth($token, $ip = null): ?User
    {
        $apiToken = $this->findToken($token, $ip);
        if (!$apiToken)
            return null;
        if ($apiToken->isTokenExpired()) {
            $this->delete($apiToken);
            return null;
        }
        $this->apiTokenRepository->touch($apiToken);
        $user = $apiToken->user;
        $user->apiToken = $apiToken;
        return $user;
    }

    public function findAllTokensByUser(User $user): Collection
    {
        return $this->apiTokenRepository->findAllByUserIdAndRole($user->id, $user->getMyRole());
    }

    /**
     * @param User $user
     * @param null $ip
     * @param bool $remember
     * @return ApiToken|null
     * @throws \Illuminate\Validation\ValidationException
     */
    public function createNewTokenForUser(User $user, $ip = null, $remember = false): ?ApiToken
    {
        $userToken = new ApiTokenDTO([
            "token" => generate_api_token(),
            "ip" => $ip,
            "user_id" => $user->id,
            "user_role" => $user->getMyRole(),
            "remember" => $remember
        ]);

        /** @var ApiToken $apiToken */
        $apiToken = $userToken->buildModel(ApiToken::class);

        if ($this->apiTokenRepository->save($apiToken))
            return $apiToken;
        else
            return null;
    }

    public function touch(ApiToken $token): bool
    {
        return $this->apiTokenRepository->touch($token);
    }

    public function delete(ApiToken $token): bool
    {
        return $this->apiTokenRepository->delete($token);
    }
}