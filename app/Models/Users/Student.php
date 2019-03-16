<?php

namespace App\Models\Users;

use App\DTO\StudentDTO;
use App\Models\Group;
use App\Models\HasDTO;
use App\Models\Visit;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class Student
 *
 * @property integer $id
 * @property string $login
 * @property string $firstname
 * @property string $surname
 * @property string $middlename
 * @property string $password
 * @property string $device_uid
 * @property integer $group_id
 * @property Group $group
 * @property Collection $visits
 * @package App\Models\Users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\Student newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\Student newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\Student query()
 * @mixin \Eloquent
 */
class Student extends User
{
    use HasDTO;

    protected $table = 'students';

    protected $fillable = [
        'login', 'firstname', 'surname', 'middlename',
        'device_uid',
        'group_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function group()
    {
        return $this->hasOne(Group::class, 'id', 'group_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function visits()
    {
        return $this->hasMany(Visit::class, 'student_id', 'id');
    }

    public static function getDTOClass(): string
    {
        return StudentDTO::class;
    }
}