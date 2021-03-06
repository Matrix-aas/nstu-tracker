<?php


namespace App\Models;


use App\DTO\DisciplineDTO;
use App\Models\Users\Professor;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Discipline
 *
 * @property integer $id
 * @property string $name
 * @property Collection $professors
 * @property Collection $lessons
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discipline newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discipline newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discipline query()
 * @mixin \Eloquent
 */
class Discipline extends Model
{
    use HasDTO;

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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lessons()
    {
        return $this->hasMany(Lesson::class, 'discipline_id', 'id');
    }

    public static function getDTOClass(): string
    {
        return DisciplineDTO::class;
    }
}