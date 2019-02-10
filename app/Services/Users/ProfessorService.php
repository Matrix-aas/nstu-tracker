<?php

namespace App\Services\Users;

use App\Models\Users\Professor;
use App\Services\IApiTokenService;
use App\Services\Repositories\Users\IProfessorRepository;
use Illuminate\Auth\Access\AuthorizationException;

class ProfessorService implements IProfessorService
{
    private $professorRepository;
    private $apiTokenService;

    public function __construct(
        IProfessorRepository $professorRepository,
        IApiTokenService $apiTokenService
    )
    {
        $this->professorRepository = $professorRepository;
        $this->apiTokenService = $apiTokenService;
    }

    public function findByLoginAndPassword($login, $plainPassword): ?Professor
    {
        return $this->professorRepository->findByLoginAndPassword($login, $plainPassword);
    }

    /**
     * @param $login
     * @param $plainPassword
     * @param null $ip
     * @param bool $remeber
     * @return string
     * @throws AuthorizationException
     * @throws \RuntimeException
     */
    public function auth($login, $plainPassword, $ip = null, $remeber = false): string
    {
        /** @var Professor $professor */
        $professor = $this->findByLoginAndPassword($login, $plainPassword);

        if (!$professor)
            throw new AuthorizationException("Login or password incorrect!");

        $apiToken = $this->apiTokenService->createNewTokenForUser($professor, $ip, $remeber);
        if (!$apiToken)
            throw new \RuntimeException("Something went wrong!");

        return $apiToken->token;
    }
}