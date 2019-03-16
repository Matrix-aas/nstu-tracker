<?php

namespace App\Http\Controllers;

use App\Services\IVisitService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Router;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class Visit extends Controller
{
    /**
     * @var IVisitService
     */
    private $service;

    public function __construct(IVisitService $service)
    {
        $this->service = $service;
    }

    public function mark(Request $request, int $lessonId)
    {
        $studentIds = $request->post("studentIds");

        foreach ($studentIds as $studentId)
            if (!is_numeric($studentId))
                throw new UnprocessableEntityHttpException("All ids must be integer!");

        $date = $request->post("date", null);
        if ($date) {
            $date = Carbon::parse($date);
        } else {
            $date = Carbon::now();
        }

        return $this->service->mark($studentIds, $lessonId, $date);
    }

    public function unmark(Request $request, int $id)
    {
        return response($this->service->unmark($id) ? "success" : "fail");
    }

    public function findById(Request $request, int $id)
    {
        return $this->service->findById($id);
    }

    public function find(Request $request)
    {
        $studentId = $request->get('studentId', null);
        if ($studentId && !empty($studentId) && !is_numeric($studentId))
            throw new UnprocessableEntityHttpException("studentId must be integer!");

        $lessonId = $request->get('lessonId', null);
        if ($lessonId && !empty($lessonId) && !is_numeric($lessonId))
            throw new UnprocessableEntityHttpException("lessonId must be integer!");

        $date = $request->get('date', null);
        if ($date) {
            $date = Carbon::parse($date);
        } else if ($date && !($date instanceof Carbon)) {
            $date = null;
        }

        return $this->service->find($studentId, $lessonId, $date);
    }

    public static function setupRouter(Router $router)
    {
        static::addToRouter($router, "get", "{id}", "findById");
        static::addToRouter($router, "get", "find", "find");

        static::addToRouter($router, "post", "{lessonId}", "mark");
        static::addToRouter($router, "delete", "{id}", "unmark");
    }
}