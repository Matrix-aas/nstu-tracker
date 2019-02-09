<?php

namespace App\Services;

use App\Services\Repositories\IVisitRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class VisitService extends EmptyCrudService implements IVisitService
{
    private $visitRepository;

    public function __construct(IVisitRepository $visitRepository)
    {
        $this->visitRepository = $visitRepository;
    }

    public function findAll(): Collection
    {
        return $this->visitRepository->findAll();
    }

    public function findById(int $id): Model
    {
        return $this->visitRepository->findById($id);
    }

    public function delete(int $id): bool
    {
        return $this->visitRepository->delete($this->findById($id));
    }
}