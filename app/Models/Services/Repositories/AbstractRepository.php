<?php


namespace App\Models\Services\Repositories;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository implements IRepository
{
    public $modelClass;

    /**
     * Find all entities
     * @return Collection
     */
    public function findAll(): Collection
    {
        return $this->modelClass::all();
    }

    /**
     * Find one entity by id
     * @param int $id
     * @return Model
     */
    public function find(int $id): Model
    {
        return $this->modelClass::query()->findById($id);
    }

    /**
     * Save entity
     * @param Model $model
     * @return bool
     */
    public function save(Model $model): bool
    {
        return $model->save();
    }

    /**
     * Delete entity
     * @param Model $model
     * @return bool
     */
    public function delete(Model $model): bool
    {
        try {
            return $model->delete();
        } catch (\Exception $exception) {
            return false;
        }
    }
}