<?php


namespace App\Services\Repositories;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface IRepository
{
    /**
     * Find all entities
     * @return Collection
     */
    public function findAll(): Collection;

    /**
     * Find one entity by id
     * @param int $id
     * @return Model
     */
    public function findById(int $id): Model;

    /**
     * Save entity
     * @param Model $model
     * @return bool
     */
    public function save(Model $model): bool;

    /**
     * Delete entity
     * @param Model $model
     * @return bool
     */
    public function delete(Model $model): bool;
}