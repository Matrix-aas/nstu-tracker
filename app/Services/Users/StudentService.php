<?php

namespace App\Services\Users;

use App\Models\Users\Student;
use App\Services\IApiTokenService;
use App\Services\Repositories\Users\IStudentRepository;
use Illuminate\Auth\Access\AuthorizationException;

class StudentService implements IStudentService
{
    private $studentRepository;
    private $apiTokenService;

    public function __construct(
        IStudentRepository $studentRepository,
        IApiTokenService $apiTokenService
    )
    {
        $this->studentRepository = $studentRepository;
        $this->apiTokenService = $apiTokenService;
    }

    public function findByLoginAndPassword($login, $plainPassword): ?Student
    {
        return $this->studentRepository->findByLoginAndPassword($login, $plainPassword);
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
        /** @var Student $student */
        $student = $this->findByLoginAndPassword($login, $plainPassword);

        if (!$student)
            throw new AuthorizationException("Login or password incorrect!");

        $apiToken = $this->apiTokenService->createNewTokenForUser($student, $ip, $remeber);
        if (!$apiToken)
            throw new \RuntimeException("Something went wrong!");

        return $apiToken->token;
    }
}