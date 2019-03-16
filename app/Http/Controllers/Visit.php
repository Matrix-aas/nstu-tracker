<?php

namespace App\Http\Controllers;

use App\DTO\VisitDTO;
use App\Services\IVisitService;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\EntityNotFoundException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Router;
use phpDocumentor\Reflection\Types\Array_;
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

        $results = $this->service->mark($studentIds, $lessonId, $date);
        $data = [];
        if ($results) {
            if (!is_array($results)) {
                $data[] = new VisitDTO($results);
            } else {
                foreach ($results as $result) {
                    $data[] = new VisitDTO($result);
                }
            }
        } else {
            return response('fail');
        }

        return $data;
    }

    public function unmark(Request $request, int $id)
    {
        return response($this->service->unmark($id) ? "success" : "fail");
    }

    public function findById(Request $request, int $id)
    {
        $visit = $this->service->findById($id);
        if ($visit)
            return new VisitDTO($visit);
        throw new EntityNotFoundException("Visit", $id);
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

        $results = $this->service->find($studentId, $lessonId, $date);
        $data = [];
        if ($results) {
            if ($results instanceof \App\Models\Visit) {
                $data[] = new VisitDTO($results);
            } else if ($results instanceof Collection) {
                foreach ($results as $result) {
                    $data[] = new VisitDTO($result);
                }
            }
        }

        return $data;
    }

    public static function setupRouter(Router $router)
    {
        static::addToRouter($router, "get", "{id:[0-9]+}", "findById");
        static::addToRouter($router, "get", "find", "find");

        static::addToRouter($router, "post", "{lessonId:[0-9]+}", "mark");
        static::addToRouter($router, "delete", "{id:[0-9]+}", "unmark");
    }
}