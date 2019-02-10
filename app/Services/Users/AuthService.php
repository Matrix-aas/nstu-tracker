<?php


namespace App\Services\Users;


use App\Models\ApiToken;
use App\Models\Users\User;
use App\Services\IApiTokenService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;

class AuthService implements IAuthService
{
    private $apiTokenService;

    public function __construct(IApiTokenService $apiTokenService)
    {
        $this->apiTokenService = $apiTokenService;
    }

    public function getAllTokensData()
    {
        if (!Auth::check())
            return response("Unauthorized.", 401);

        /** @var User $authUser */
        $authUser = Auth::user();

        $tokensCollection = $this->apiTokenService->findAllTokensByUser($authUser);
        $tokens = [];
        foreach ($tokensCollection as $token) {
            /** @var ApiToken $token */
            $tokens[] = [
                "token" => $token->token,
                "ip" => $token->ip,
                "expired_at" => $token->updated_at->addMinutes(ApiToken::TOKEN_EXPIRED_MINUTES),
                "remembered" => $token->isRemembered()
            ];
        }
        return $tokens;
    }

    public function logout(): void
    {
        if (!Auth::check())
            throw new UnauthorizedException("Logout can only authorized users!");
        /** @var User $user */
        $user = Auth::user();
        if (!$user->apiToken)
            throw new \RuntimeException("Authorized user doesn't contains ApiToken!");

        if (!$this->apiTokenService->delete($user->apiToken))
            throw new \RuntimeException("Can't logout user!");
    }
}