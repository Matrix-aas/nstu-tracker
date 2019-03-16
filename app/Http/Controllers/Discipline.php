<?php

namespace App\Http\Controllers;

use App\DTO\DisciplineDTO;
use App\Services\IDisciplineService;
use App\Services\IProfessorDisciplineService;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Router;

class Discipline extends AbstractCrudController
{
    /**
     * @var IProfessorDisciplineService
     */
    private $professorDisciplineService;

    public function __construct(IDisciplineService $disciplineService, IProfessorDisciplineService $professorDisciplineService)
    {
        parent::__construct($disciplineService);
        $this->professorDisciplineService = $professorDisciplineService;
    }

    public function findByProfessorId(Request $request, int $professorId)
    {
        /** @var IDisciplineService $service */
        $service = $this->crudService;
        $disciplines = $service->findByProfessorId($professorId);
        $result = [];
        foreach ($disciplines as $discipline) {
            $result[] = new DisciplineDTO($discipline);
        }
        return $result;
    }

    /**
     * @param Request $request
     * @param int $id
     * @param int $professorId
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function attachProfessor(Request $request, int $id, int $professorId)
    {
        return response($this->professorDisciplineService->attachProfessor($id, $professorId) ? "success" : "fail");
    }

    /**
     * @param Request $request
     * @param int $id
     * @param int $professorId
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function detachProfessor(Request $request, int $id, int $professorId)
    {
        return response($this->professorDisciplineService->detachProfessor($id, $professorId) ? "success" : "fail");
    }

    /**
     * @param Router $router
     * @param array $functionality
     */
    public static function setupRouter(Router $router, array $functionality = ['findAll', 'findById', 'create', 'update', 'delete', 'attachProfessor', 'detachProfessor', 'findByProfessorId'])
    {
        parent::setupRouter($router, $functionality);

        if (in_array('attachProfessor', $functionality))
            self::addToRouter($router, 'put', '{id:[0-9]+}/professor/{professorId:[0-9]+}/attach', "attachProfessor");
        if (in_array('detachProfessor', $functionality))
            self::addToRouter($router, 'put', '{id:[0-9]+}/professor/{professorId:[0-9]+}/detach', "detachProfessor");
        if (in_array('findByProfessorId', $functionality))
            self::addToRouter($router, 'get', 'find/professor/{professorId:[0-9]+}', "findByProfessorId");
    }
}
