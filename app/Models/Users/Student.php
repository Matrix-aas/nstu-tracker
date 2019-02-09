<?php

namespace App\Models\Users;

class Student extends User
{
    protected $table = 'students';

    protected $fillable = [
        'login', 'firstname', 'surname', 'middlename',
        'device_uid',
        'group_id'
    ];
}