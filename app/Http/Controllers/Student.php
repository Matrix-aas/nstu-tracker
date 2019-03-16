<?php

namespace App\Http\Controllers;

use App\DTO\VisitDTO;
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

    public function mark(Request $request, int $id, int $lessonId)
    {
        $date = $request->post("date", null);
        if ($date) {
            $date = Carbon::parse($date);
        } else {
            $date = Carbon::now();
        }
        
        $result = $this->visitService->mark($id, $lessonId, $date);
        if ($result)
            return new VisitDTO($result);
        return response("fail");
    }

    /**
     * @param Router $router
     * @param array $functionality
     */
    public static function setupRouter(Router $router, array $functionality = ['findAll', 'findById', 'create', 'update', 'delete', 'mark'])
    {
        parent::setupRouter($router, $functionality);

        if (in_array('mark', $functionality))
            static::addToRouter($router, 'post', '{id:[0-9]+}/lesson/{lessonId:[0-9]+}/mark', "mark");
    }
}
