<?php

namespace App\Http\Controllers;

use App\Models\Services\Repositories\IGroupRepository;

class Group extends Controller
{
    private $groupRepository;

    public function __construct(IGroupRepository $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

    public function findAll()
    {
        return $this->groupRepository->findAll();
    }
}
