<?php

namespace App\Http\Controllers;

use App\Services\IVisitService;
use App\Services\Users\IStudentService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Router;

class Student extends AbstractCrudController
{
    private $visitService;

    /**
     * Student constructor.
     * @param IStudentService $studentService
     * @param IVisitService $visitService
     */
    public function __construct(IStudentService $studentService, IVisitService $visitService)
    {
        parent::__construct($studentService);
        $this->visitService = $visitService;
    }

    /**
     * @param Request $request
     * @param int $id
     * @param int $lessonId
     * @return \App\Models\Visit|\App\Models\Visit[]
     */
    public function mark(Request $request, int $id, int $lessonId)
    {
        $date = $request->post("date", null);
        if ($date) {
            $date = Carbon::parse($date);
        } else {
            $date = Carbon::now();
        }
        return $this->visitService->mark($id, $lessonId, $date);
    }

    /**
     * @param Router $router
     * @param array $functionality
     */
    public static function setupRouter(Router $router, array $functionality = ['findAll', 'findById', 'create', 'update', 'delete', 'mark'])
    {
        parent::setupRouter($router, $functionality);

        if (in_array('mark', $functionality))
            static::addToRouter($router, 'post', '{id}/lesson/{lessonId}/mark', "mark");
    }
}
