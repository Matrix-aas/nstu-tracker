<?php

namespace App\Services;

use App\DTO\AbstractDTO;
use Illuminate\Database\Eloquent\Collection;

interface IAbstractCrudService
{
    public function findAll(): Collection;

    public function findById(int $id): ?AbstractDTO;

    public function create(AbstractDTO $DTO): ?AbstractDTO;

    public function update(AbstractDTO $DTO): ?AbstractDTO;

    public function updateOrCreate(AbstractDTO $DTO): ?AbstractDTO;

    public function delete(int $id): bool;

    public function getDTOClass(): string;
}