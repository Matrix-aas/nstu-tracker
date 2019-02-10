<?php

namespace App\Http\Controllers;

use App\Services\IGroupService;

class Group extends AbstractCrudController
{
    public function __construct(IGroupService $groupService)
    {
        parent::__construct($groupService);
    }
}
