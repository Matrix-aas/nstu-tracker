<?php

namespace App\Services\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractCrudRepository implements IAbstractCrudRepository
{
    protected $modelClass;

    public function findAll(): Collection
    {
        return $this->modelClass::all();
    }

    public function findById(int $id): ?Model
    {
        $model = $this->modelClass::query()->find($id);
        if ($model instanceof Collection)
            $model = $model->first();
        return $model;
    }

    public function create(Model $model): bool
    {
        if ($model->getKey() !== null || $model->exists)
            return false;
        return $model->save();
    }

    public function update(Model $model): bool
    {
        if ($model->getKey() === null || !$model->exists)
            return false;
        return $model->save();
    }

    public function updateOrCreate(Model $model): bool
    {
        return $model->save();
    }

    public function delete(Model $model): bool
    {
        try {
            return $model->delete();
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function deleteById(int $id): bool
    {
        return $this->delete($this->findById($id));
    }

    public function exists(int $id): bool
    {
        return $this->modelClass::query()->whereKey($id)->exists();
    }
}