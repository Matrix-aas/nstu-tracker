<?php


namespace App\Models;


use App\Models\Users\Professor;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Lesson
 * @property integer $id
 * @property string $name
 * @property Carbon $datetime
 * @property integer $professor_id
 * @property Professor $professor
 * @property Collection $disciplines
 * @property Collection $groups
 * @package app\Models
 */
class Lesson extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name', 'datetime', 'professor_id'
    ];

    protected $dates = [
        'datetime'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function professor()
    {
        return $this->hasOne(Professor::class, 'id', 'professor_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function disciplines()
    {
        return $this->belongsToMany(Discipline::class, 'discipline_lesson', 'lesson_id', 'discipline_id', 'id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_lesson', 'lesson_id', 'group_id', 'id', 'id');
    }
}