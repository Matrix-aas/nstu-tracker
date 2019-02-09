<?php

namespace App\Models\Users;

use App\Models\Discipline;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class Professor
 * @property integer $id
 * @property string $login
 * @property string $firstname
 * @property string $surname
 * @property string $middlename
 * @property string $password
 * @property Collection $disciplines
 * @package App\Models\Users
 */
class Professor extends User
{
    protected $table = 'professors';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function disciplines()
    {
        return $this->belongsToMany(Discipline::class, 'professor_discipline', 'professor_id', 'discipline_id', 'id', 'id');
    }
}