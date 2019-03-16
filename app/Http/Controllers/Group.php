<?php

namespace App\Http\Controllers;

use App\Services\IGroupLessonService;
use App\Services\IGroupService;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Router;

class Group extends AbstractCrudController
{
    /**
     * @var IGroupLessonService
     */
    private $groupLessonService;

    public function __construct(IGroupService $groupService, IGroupLessonService $groupLessonService)
    {
        parent::__construct($groupService);
        $this->groupLessonService = $groupLessonService;
    }

    /**
     * @param Request $request
     * @param int $id
     * @param int $lessonId
     * @return bool
     */
    public function attachLesson(Request $request, int $id, int $lessonId)
    {
        return $this->groupLessonService->attachLesson($id, $lessonId);
    }

    /**
     * @param Request $request
     * @param int $id
     * @param int $lessonId
     * @return bool
     */
    public function detachLesson(Request $request, int $id, int $lessonId)
    {
        return $this->groupLessonService->detachLesson($id, $lessonId);
    }

    /**
     * @param Router $router
     * @param array $functionality
     */
    public static function setupRouter(Router $router, array $functionality = ['findAll', 'findById', 'create', 'update', 'delete', 'attachLesson', 'detachLesson'])
    {
        parent::setupRouter($router, $functionality);

        if (in_array('attachLesson', $functionality))
            self::addToRouter($router, 'put', '{id}/lesson/{lessonId}/attach', "attachLesson");
        if (in_array('detachLesson', $functionality))
            self::addToRouter($router, 'put', '{id}/lesson/{lessonId}/detach', "detachLesson");
    }
}
