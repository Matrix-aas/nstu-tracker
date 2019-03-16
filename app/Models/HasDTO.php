<?php

namespace App\Models;

trait HasDTO
{
    public function getMyDTOClass(): string
    {
        return static::getDTOClass();
    }

    public static function getDTOClass(): string
    {
        throw new \RuntimeException("Unhandled DTO Class!");
    }
}