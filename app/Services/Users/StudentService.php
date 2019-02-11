<?php

namespace App\Services\Users;

use App\DTO\AbstractDTO;
use App\DTO\StudentDTO;
use App\Models\Users\Student;
use App\Services\AbstractCrudService;
use App\Services\IApiTokenService;
use App\Services\Repositories\Users\IStudentRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Hash;

class StudentService extends AbstractCrudService implements IStudentService
{
    protected $modelClass = Student::class;
    protected $dtoClass = StudentDTO::class;

    private $studentRepository;
    private $apiTokenService;

    public function __construct(
        IStudentRepository $studentRepository,
        IApiTokenService $apiTokenService
    )
    {
        $this->studentRepository = $studentRepository;
        $this->apiTokenService = $apiTokenService;
        parent::__construct($studentRepository);
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

    protected function handleDto(AbstractDTO $DTO)
    {
        /** @var StudentDTO $DTO */
        if (isset($DTO->plainPassword) && !empty($DTO->getPlainPassword()))
            $DTO->password = Hash::make($DTO->getPlainPassword());
        parent::handleDto($DTO);
    }
}