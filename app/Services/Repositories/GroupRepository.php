<?php

namespace App\Services\Repositories;

use App\Models\Group;

class GroupRepository extends AbstractCrudRepository implements IGroupRepository
{
    protected $modelClass = Group::class;
}