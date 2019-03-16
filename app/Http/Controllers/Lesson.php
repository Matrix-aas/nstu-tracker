<?php

namespace App\Http\Controllers;

use App\Services\IGroupLessonService;
use App\Services\ILessonService;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Router;

class Lesson extends AbstractCrudController
{
    /**
     * @var IGroupLessonService
     */
    private $groupLessonService;

    public function __construct(ILessonService $lessonService, IGroupLessonService $groupLessonService)
    {
        parent::__construct($lessonService);
        $this->groupLessonService = $groupLessonService;
    }

    /**
     * @param Request $request
     * @param int $id
     * @param int $groupId
     * @return bool
     */
    public function attachGroup(Request $request, int $id, int $groupId)
    {
        return $this->groupLessonService->attachGroup($id, $groupId);
    }

    /**
     * @param Request $request
     * @param int $id
     * @param int $groupId
     * @return bool
     */
    public function detachGroup(Request $request, int $id, int $groupId)
    {
        return $this->groupLessonService->detachGroup($id, $groupId);
    }

    /**
     * @param Router $router
     * @param array $functionality
     */
    public static function setupRouter(Router $router, array $functionality = ['findAll', 'findById', 'create', 'update', 'delete', 'attachGroup', 'detachGroup'])
    {
        parent::setupRouter($router, $functionality);

        if (in_array('attachGroup', $functionality))
            self::addToRouter($router, 'put', '{id}/group/{groupId}/attach', "attachGroup");
        if (in_array('detachGroup', $functionality))
            self::addToRouter($router, 'put', '{id}/group/{groupId}/detach', "detachGroup");
    }
}
