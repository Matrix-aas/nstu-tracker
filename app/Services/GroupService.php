<?php


namespace App\Services;

use App\Services\Repositories\IGroupRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class GroupService extends EmptyCrudService implements IGroupService
{
    private $groupRepository;

    public function __construct(IGroupRepository $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

    public function findAll(): Collection
    {
        return $this->groupRepository->findAll();
    }

    public function findById(int $id): Model
    {
        return $this->groupRepository->findById($id);
    }

    public function delete(int $id): bool
    {
        return $this->groupRepository->delete($this->findById($id));
    }
}