<?php

namespace App\Http\Controllers;

use App\Services\IGroupService;

class Group extends Controller
{
    private $groupService;

    public function __construct(IGroupService $groupService)
    {
        $this->groupService = $groupService;
    }
}
