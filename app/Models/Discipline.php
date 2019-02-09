<?php


namespace App\Models;


use App\Models\Users\Professor;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Discipline
 * @property integer $id
 * @property string $name
 * @property Collection $professors
 * @property Collection $lessons
 * @package app\Models
 */
class Discipline extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function professors()
    {
        return $this->belongsToMany(Professor::class, 'professor_discipline', 'discipline_id', 'professor_id', 'id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function lessons()
    {
        return $this->belongsToMany(Lesson::class, 'discipline_lesson', 'discipline_id', 'lesson_id', 'id', 'id');
    }
}