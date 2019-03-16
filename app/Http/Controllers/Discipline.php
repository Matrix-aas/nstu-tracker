<?php

namespace App\Http\Controllers;

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
    public static function setupRouter(Router $router, array $functionality = ['findAll', 'findById', 'create', 'update', 'delete', 'attachProfessor', 'detachProfessor'])
    {
        parent::setupRouter($router, $functionality);

        if (in_array('attachProfessor', $functionality))
            self::addToRouter($router, 'put', '{id}/professor/{professorId}/attach', "attachProfessor");
        if (in_array('detachProfessor', $functionality))
            self::addToRouter($router, 'put', '{id}/professor/{professorId}/detach', "detachProfessor");
    }
}
