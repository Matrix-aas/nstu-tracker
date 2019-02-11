<?php

namespace App\Services\Users;

use App\DTO\AdminDTO;
use App\Models\Users\Admin;
use App\Services\IApiTokenService;
use App\Services\Repositories\Users\IAdminRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Hash;

class AdminService implements IAdminService
{
    private $adminRepository;
    private $apiTokenService;

    public function __construct(
        IAdminRepository $adminRepository,
        IApiTokenService $apiTokenService
    )
    {
        $this->adminRepository = $adminRepository;
        $this->apiTokenService = $apiTokenService;
    }

    /**
     * @param AdminDTO $dto
     * @return bool
     * @throws \Illuminate\Validation\ValidationException
     */
    public function save(AdminDTO $dto): bool
    {
        /** @var AdminDTO $dto */
        /** @var Admin $adminModel */
        $adminModel = $dto->buildModel(Admin::class, true);
        $adminModel->password = Hash::make($dto->getPlainPassword());
        return $adminModel->save();
    }

    public function findByLoginAndPassword($login, $plainPassword): ?Admin
    {
        return $this->adminRepository->findByLoginAndPassword($login, $plainPassword);
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
        /** @var Admin $admin */
        $admin = $this->findByLoginAndPassword($login, $plainPassword);

        if (!$admin)
            throw new AuthorizationException("Login or password incorrect!");

        $apiToken = $this->apiTokenService->createNewTokenForUser($admin, $ip, $remeber);
        if (!$apiToken)
            throw new \RuntimeException("Something went wrong!");

        return $apiToken->token;
    }
}