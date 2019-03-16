<?php


namespace App\Models;


use App\DTO\VisitDTO;
use App\Models\Users\Student;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Visit
 *
 * @property integer $id
 * @property integer $lesson_id
 * @property integer $student_id
 * @property Lesson $lesson
 * @property Student $student
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Visit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Visit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Visit query()
 * @mixin \Eloquent
 */
class Visit extends Model
{
    use HasDTO;

    protected $fillable = [
        'lesson_id', 'student_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function lesson()
    {
        return $this->hasOne(Lesson::class, 'id', 'lesson_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function student()
    {
        return $this->hasOne(Student::class, 'id', 'student_id');
    }

    public static function getDTOClass(): string
    {
        return VisitDTO::class;
    }
}