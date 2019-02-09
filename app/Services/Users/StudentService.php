<?php

namespace App\Services\Users;

use App\Services\EmptyCrudService;
use App\Services\Repositories\Users\IStudentRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class StudentService extends EmptyCrudService implements IAdminService
{
    private $studentRepository;

    public function __construct(IStudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    public function findAll(): Collection
    {
        return $this->studentRepository->findAll();
    }

    public function findById(int $id): Model
    {
        return $this->studentRepository->findById($id);
    }

    public function delete(int $id): bool
    {
        return $this->studentRepository->delete($this->findById($id));
    }
}