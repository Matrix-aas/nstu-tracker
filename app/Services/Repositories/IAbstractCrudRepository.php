<?php

namespace App\Services\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface IAbstractCrudRepository
{
    public function findAll(): Collection;

    public function findById(int $id): ?Model;

    public function create(Model $model): bool;

    public function update(Model $model): bool;

    public function updateOrCreate(Model $model): bool;

    public function delete(Model $model): bool;

    public function deleteById(int $id): bool;

    public function exists(int $id): bool;
}