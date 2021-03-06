<?php

namespace App\Http\Controllers;

use App\Services\IProfessorDisciplineService;
use App\Services\Users\IProfessorService;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Router;

class Professor extends AbstractCrudController
{
    /**
     * @var IProfessorDisciplineService
     */
    private $professorDisciplineService;

    public function __construct(IProfessorService $professorService, IProfessorDisciplineService $professorDisciplineService)
    {
        parent::__construct($professorService);
        $this->professorDisciplineService = $professorDisciplineService;
    }

    /**
     * @param Request $request
     * @param int $id
     * @param int $disciplineId
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function attachDiscipline(Request $request, int $id, int $disciplineId)
    {
        return response($this->professorDisciplineService->attachDiscipline($id, $disciplineId) ? "success" : "fail");
    }

    /**
     * @param Request $request
     * @param int $id
     * @param int $disciplineId
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function detachDiscipline(Request $request, int $id, int $disciplineId)
    {
        return response($this->professorDisciplineService->detachDiscipline($id, $disciplineId) ? "success" : "fail");
    }

    /**
     * @param Router $router
     * @param array $functionality
     */
    public static function setupRouter(Router $router, array $functionality = ['findAll', 'findById', 'create', 'update', 'delete', 'attachDiscipline', 'detachDiscipline'])
    {
        parent::setupRouter($router, $functionality);

        if (in_array('attachDiscipline', $functionality))
            self::addToRouter($router, 'put', '{id}/discipline/{disciplineId}/attach', "attachDiscipline");
        if (in_array('detachDiscipline', $functionality))
            self::addToRouter($router, 'put', '{id}/discipline/{disciplineId}/detach', "detachDiscipline");
    }
}
