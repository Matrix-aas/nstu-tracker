<?php

namespace App\Models\Users;

/**
 * Class Admin
 * @property integer $id
 * @property string $login
 * @property string $firstname
 * @property string $surname
 * @property string $middlename
 * @property string $password
 * @package App\Models\Users
 */
class Admin extends User
{
    protected $table = 'admins';
}