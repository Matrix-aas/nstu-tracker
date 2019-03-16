<?php


namespace App\Models;


use App\DTO\GroupDTO;
use App\Models\Users\Student;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Group
 *
 * @property integer $id
 * @property string $name
 * @property Collection $lessons
 * @property Collection $students
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Group newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Group newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Group query()
 * @mixin \Eloquent
 */
class Group extends Model
{
    use HasDTO;

    public $timestamps = false;

    protected $fillable = [
        'name'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function lessons()
    {
        return $this->belongsToMany(Lesson::class, 'group_lesson', 'group_id', 'lesson_id', 'id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function students()
    {
        return $this->hasMany(Student::class, 'group_id', 'id');
    }

    public static function getDTOClass(): string
    {
        return GroupDTO::class;
    }
}