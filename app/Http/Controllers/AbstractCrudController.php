<?php

namespace App\Http\Controllers;

use App\DTO\AbstractDTO;
use App\Services\IAbstractCrudService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Routing\Router;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AbstractCrudController extends Controller implements IAbstractCrudController
{
    protected $crudService;

    public function __construct(IAbstractCrudService $crudService)
    {
        $this->crudService = $crudService;
    }

    public function findAll(Request $request)
    {
        return $this->crudService->findAll();
    }


    /**
     * @param Request $request
     * @param int $id
     * @return AbstractDTO
     */
    public function findById(Request $request, $id)
    {
        $dto = $this->crudService->findById($id);
        if (!$dto)
            throw new ModelNotFoundException("Model with id '$id' not found!", 404);
        return $dto;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     * @throws ValidationException
     * @throws HttpException
     */
    public function create(Request $request)
    {
        $dto = $this->buildDto();
        $validationRules = $dto->getValidationRules();
        if ($validationRules) {
            $validationMessages = $dto->getValidationMessages();
            $validator = Validator::make($request->post(), $validationRules, $validationMessages ?? []);
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }
        }

        try {
            $dto = $this->buildDto($request->post());
        } catch (\InvalidArgumentException $exception) {
            throw new HttpException(400, "One of object attribute is invalid!");
        }

        $dto = $this->crudService->create($dto);

        if ($dto) {
            return response()->json([
                'message' => 'success',
                'model' => $dto->toArray()
            ]);
        } else {
            throw new HttpException(500, "Can't save model!");
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     * @throws HttpException
     * @throws \HttpInvalidParamException
     */
    public function update(Request $request, $id)
    {
        $request->except(['id']);

        $dto = $this->buildDto();
        $validationRules = array_merge($dto->getValidationRules(), ['id' => 'required|integer|min:1']);
        if ($validationRules) {

            array_walk($validationRules, function (&$value, $key) {
                if ($key != 'id')
                    $value = implode("|", array_diff(explode("|", $value), ['required']));
            });

            $validationMessages = $dto->getValidationMessages();
            $validator = Validator::make(array_merge($request->input(), ['id' => $id]), $validationRules, $validationMessages ?? []);
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }
        }

        try {
            $dto = $this->buildDto($request->post());
            $dto->setId($id);
            $dto->removeEmptyFields();
        } catch (\InvalidArgumentException $exception) {
            throw new \HttpInvalidParamException("One of object attribute is invalid!", 400);
        }

        $dto = $this->crudService->update($dto);

        if ($dto) {
            return response()->json([
                'message' => 'success',
                'model' => $dto->toArray()
            ]);
        } else {
            throw new HttpException(500, "Can't update model!");
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     * @throws HttpException
     */
    public function delete(Request $request, $id)
    {
        if ($this->crudService->delete($id)) {
            return response("success");
        } else {
            throw new HttpException(500, "Can't delete model!");
        }
    }

    /**
     * Add handler from self to router
     * @param Router $router
     * @param string $method
     * @param null|string $uri
     * @param string $controllerMethod
     */
    public static function addToRouter(Router $router, string $method, ?string $uri, string $controllerMethod)
    {
        static $className = null;

        if (!$className) {
            try {
                $className = (new \ReflectionClass(static::class))->getShortName();
            } catch (\ReflectionException $exception) {
                throw new \RuntimeException("Can't setupRouter on \"" . static::class . "\"", 500);
            }
        }
        
        $router->group(["prefix" => camel_case($className)], function (Router $router) use ($className, $method, $uri, $controllerMethod) {
            $router->$method($uri, $className . "@" . $controllerMethod);
        });
    }

    /**
     * Setup default abstract crud router
     * @param Router $router
     * @param array $functionality
     */
    public static function setupRouter(Router $router, array $functionality = ['findAll', 'findById', 'create', 'update', 'delete'])
    {
        if (in_array('findAll', $functionality))
            static::addToRouter($router, 'get', null, "findAll");
        if (in_array('findById', $functionality))
            static::addToRouter($router, 'get', "{id}", "findById");
        if (in_array('create', $functionality))
            static::addToRouter($router, 'post', null, "create");
        if (in_array('update', $functionality))
            static::addToRouter($router, 'put', "{id}", "update");
        if (in_array('delete', $functionality))
            static::addToRouter($router, 'delete', "{id}", "delete");
    }

    /**
     * @return AbstractDTO
     */
    private function buildDto(array $attributes = [])
    {
        $dtoClass = $this->crudService->getDTOClass();
        return new $dtoClass($attributes);
    }
}