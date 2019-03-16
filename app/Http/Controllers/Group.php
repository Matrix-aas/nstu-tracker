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
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function attachLesson(Request $request, int $id, int $lessonId)
    {
        return response($this->groupLessonService->attachLesson($id, $lessonId) ? "success" : "fail");
    }

    /**
     * @param Request $request
     * @param int $id
     * @param int $lessonId
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function detachLesson(Request $request, int $id, int $lessonId)
    {
        return response($this->groupLessonService->detachLesson($id, $lessonId) ? "success" : "fail");
    }

    /**
     * @param Router $router
     * @param array $functionality
     */
    public static function setupRouter(Router $router, array $functionality = ['findAll', 'findById', 'create', 'update', 'delete', 'attachLesson', 'detachLesson'])
    {
        parent::setupRouter($router, $functionality);

        if (in_array('attachLesson', $functionality))
            self::addToRouter($router, 'put', '{id:[0-9]+}/lesson/{lessonId:[0-9]+}/attach', "attachLesson");
        if (in_array('detachLesson', $functionality))
            self::addToRouter($router, 'put', '{id:[0-9]+}/lesson/{lessonId:[0-9]+}/detach', "detachLesson");
    }
}
