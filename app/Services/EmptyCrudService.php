<?php


namespace App\Services;


use App\DTO\AbstractDTO;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class EmptyCrudService implements ICrudService
{

    public function findAll(): Collection
    {
        return null;
    }

    public function findById(int $id): Model
    {
        return null;
    }

    public function update(AbstractDTO $dto): bool
    {
        return false;
    }

    public function save(AbstractDTO $dto): bool
    {
        return false;
    }

    public function delete(int $id): bool
    {
        return false;
    }
}