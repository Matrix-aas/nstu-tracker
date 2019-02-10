<?php

namespace App\Models\Users;

use App\Models\ApiToken;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

/**
 * Abstract Class User
 * @property integer $id
 * @property string $login
 * @property string $firstname
 * @property string $surname
 * @property string $middlename
 * @property string $password
 * @package App\Models\Users
 */
abstract class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    const ROLE_STUDENT = 0;
    const ROLE_PROFESSOR = 1;
    const ROLE_ADMIN = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'login', 'firstname', 'surname', 'middlename'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Validation rules for DTO
     * @var array
     */
    public $validationRules = [
        "login" => "required|string|min:3",
        "firstname" => "required|string|min:2",
        "surname" => "required|string|min:2",
        "middlename" => "required|string|min:2"
    ];

    /**
     * @var ApiToken
     */
    public $apiToken = null;

    /**
     * @return int
     */
    public function getMyRole()
    {
        return static::getRole($this);
    }

    /**
     * @return bool
     */
    public function isStudent()
    {
        return $this->getMyRole() == static::ROLE_STUDENT;
    }

    /**
     * @return bool
     */
    public function isProfessor()
    {
        return $this->getMyRole() == static::ROLE_PROFESSOR;
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->getMyRole() == static::ROLE_ADMIN;
    }

    /**
     * @param User $model
     * @return int
     */
    public static function getRole(User $model)
    {
        if ($model instanceof Student)
            return static::ROLE_STUDENT;
        else if ($model instanceof Professor)
            return static::ROLE_PROFESSOR;
        else if ($model instanceof Admin)
            return static::ROLE_ADMIN;
        throw new \RuntimeException("Unhandled user model!");
    }
}
