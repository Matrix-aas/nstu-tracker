<?php

namespace App\Models\Users;

use App\DTO\AdminDTO;
use App\Models\HasDTO;

/**
 * Class Admin
 *
 * @property integer $id
 * @property string $login
 * @property string $firstname
 * @property string $surname
 * @property string $middlename
 * @property string $password
 * @package App\Models\Users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\Admin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\Admin query()
 * @mixin \Eloquent
 */
class Admin extends User
{
    use HasDTO;

    protected $table = 'admins';

    public static function getDTOClass(): string
    {
        return AdminDTO::class;
    }
}