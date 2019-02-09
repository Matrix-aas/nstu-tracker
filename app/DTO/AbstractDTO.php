<?php

namespace App\Models\DTO;

abstract class AbstractDTO
{
    /**
     * Convert all this class fields to array
     * @return array
     */
    public function toArray()
    {
        return get_object_vars($this);
    }
}