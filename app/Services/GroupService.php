<?php

namespace App\Services;

use App\DTO\GroupDTO;
use App\Models\Group;
use App\Services\Repositories\IGroupRepository;

class GroupService extends AbstractCrudService implements IGroupService
{
    protected $modelClass = Group::class;
    protected $dtoClass = GroupDTO::class;

    public function __construct(IGroupRepository $groupRepository)
    {
        parent::__construct($groupRepository);
    }
}