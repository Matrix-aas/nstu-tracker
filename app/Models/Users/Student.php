<?php

namespace App\Models\Users;

use App\Models\Group;

/**
 * Class Student
 * @property integer $id
 * @property string $login
 * @property string $firstname
 * @property string $surname
 * @property string $middlename
 * @property string $password
 * @property string $device_uid
 * @property integer $group_id
 * @property Group $group
 * @package App\Models\Users
 */
class Student extends User
{
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
}