<?php

namespace App\Services;

use App\DTO\AbstractDTO;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface ICrudService
{
    public function findAll(): Collection;

    public function findById(int $id): Model;

    public function update(AbstractDTO $dto): bool;

    public function save(AbstractDTO $dto): bool;

    public function delete(int $id): bool;
}