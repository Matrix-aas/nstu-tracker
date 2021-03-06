<?php


namespace App\Models;


use App\DTO\LessonDTO;
use App\Models\Users\Professor;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Lesson
 *
 * @property integer $id
 * @property string $name
 * @property Carbon $datetime
 * @property integer $professor_id
 * @property Professor $professor
 * @property Discipline $discipline
 * @property Collection $groups
 * @property Collection $visits
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lesson newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lesson newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lesson query()
 * @mixin \Eloquent
 */
class Lesson extends Model
{
    use HasDTO;

    public $timestamps = false;

    protected $fillable = [
        'discipline_id', 'name', 'datetime', 'professor_id'
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
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function discipline()
    {
        return $this->hasOne(Discipline::class, 'id', 'discipline_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_lesson', 'lesson_id', 'group_id', 'id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function visits()
    {
        return $this->hasMany(Visit::class, 'lesson_id', 'id');
    }

    public static function getDTOClass(): string
    {
        return LessonDTO::class;
    }
}