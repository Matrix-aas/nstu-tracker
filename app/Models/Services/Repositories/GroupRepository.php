<?php

namespace App\Models\Services\Repositories;

use App\Models\Group;

class GroupRepository extends AbstractRepository implements IGroupRepository
{
    public $modelClass = Group::class;
}