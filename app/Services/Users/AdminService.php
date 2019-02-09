<?php

namespace App\Services\Users;

use App\DTO\AbstractDTO;
use App\DTO\AdminDTO;
use App\Models\Users\Admin;
use App\Services\EmptyCrudService;
use App\Services\Repositories\Users\IAdminRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class AdminService extends EmptyCrudService implements IAdminService
{
    private $adminRepository;

    public function __construct(IAdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    public function findAll(): Collection
    {
        return $this->adminRepository->findAll();
    }

    public function findById(int $id): Model
    {
        return $this->adminRepository->findById($id);
    }

    /**
     * @param AbstractDTO $dto
     * @return bool
     * @throws \Illuminate\Validation\ValidationException
     */
    public function save(AbstractDTO $dto): bool
    {
        /** @var AdminDTO $dto */
        /** @var Admin $adminModel */
        $adminModel = $dto->buildModel(Admin::class);
        $adminModel->password = Hash::make($dto->getPassword());
        return $adminModel->save();
    }

    public function delete(int $id): bool
    {
        return $this->adminRepository->delete($this->findById($id));
    }
}