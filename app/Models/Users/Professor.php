<?php

namespace App\Models\Users;

use App\DTO\ProfessorDTO;
use App\Models\Discipline;
use App\Models\HasDTO;
use App\Models\Lesson;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class Professor
 *
 * @property integer $id
 * @property string $login
 * @property string $firstname
 * @property string $surname
 * @property string $middlename
 * @property string $password
 * @property Collection $disciplines
 * @property Collection $lessons
 * @package App\Models\Users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\Professor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\Professor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\Professor query()
 * @mixin \Eloquent
 */
class Professor extends User
{
    use HasDTO;

    protected $table = 'professors';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function disciplines()
    {
        return $this->belongsToMany(Discipline::class, 'professor_discipline', 'professor_id', 'discipline_id', 'id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lessons()
    {
        return $this->hasMany(Lesson::class, 'professor_id', 'id');
    }

    public static function getDTOClass(): string
    {
        return ProfessorDTO::class;
    }
}