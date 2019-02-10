<?php

namespace App\Services;

use App\DTO\AbstractDTO;
use App\Services\Repositories\IAbstractCrudRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;

abstract class AbstractCrudService implements IAbstractCrudService
{
    protected $crudRepository;
    protected $modelClass;
    protected $dtoClass;

    public function __construct(IAbstractCrudRepository $crudRepository)
    {
        $this->crudRepository = $crudRepository;
    }

    public function findAll(): Collection
    {
        return $this->crudRepository->findAll();
    }

    public function findById(int $id): ?AbstractDTO
    {
        $model = $this->crudRepository->findById($id);
        if (!$model)
            return null;
        /** @var AbstractDTO $dto */
        $dto = new $this->dtoClass($model);
        return $dto;
    }

    /**
     * @param AbstractDTO $DTO
     * @return bool
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(AbstractDTO $DTO): ?AbstractDTO
    {
        /** @var Model $model */
        $model = $DTO->buildModel($this->modelClass);
        if ($this->crudRepository->create($model)) {
            return new $this->dtoClass($model);
        } else {
            return null;
        }
    }

    /**
     * @param AbstractDTO $DTO
     * @return AbstractDTO|null
     * @throws \Illuminate\Validation\ValidationException|HttpException
     */
    public function update(AbstractDTO $DTO): ?AbstractDTO
    {
        if (!isset($DTO->id))
            throw new \RuntimeException("DTO '" . $this->dtoClass . "' field 'id' not found!", 500);
        if (empty($DTO->getId()))
            throw new HttpException(500, "DTO Id can't be null!");
        if (!$this->crudRepository->exists($DTO->getId()))
            throw new ModelNotFoundException("Model with id '" . $DTO->getId() . "' not found!", 404);
        /** @var Model $model */
        $model = $DTO->buildModel($this->modelClass);
        if ($this->crudRepository->update($model)) {
            return new $this->dtoClass($model);
        } else {
            return null;
        }
    }

    /**
     * @param AbstractDTO $DTO
     * @return bool
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateOrCreate(AbstractDTO $DTO): ?AbstractDTO
    {
        if (!isset($DTO->id))
            throw new \RuntimeException("DTO '" . $this->dtoClass . "' field 'id' not found!", 500);

        /** @var Model $model */
        $model = $DTO->buildModel($this->modelClass);
        if ($model->exists) {
            $result = $this->crudRepository->update($model);
        } else {
            $result = $this->crudRepository->create($model);
        }
        if ($result) {
            return new $this->dtoClass($model);
        } else {
            return null;
        }
    }

    public function delete(int $id): bool
    {
        $model = $this->crudRepository->findById($id);
        if (!$model)
            throw new ModelNotFoundException("Model with id '$id' not found!", 404);
        return $this->crudRepository->delete($model);
    }

    public function getDTOClass(): string
    {
        return $this->dtoClass;
    }
}