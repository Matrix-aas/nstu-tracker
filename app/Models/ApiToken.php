<?php

namespace App\Models;

use App\DTO\ApiTokenDTO;
use App\Models\Users\Admin;
use App\Models\Users\Professor;
use App\Models\Users\Student;
use App\Models\Users\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ApiToken
 *
 * @property string $token
 * @property string $ip
 * @property integer $user_id
 * @property integer $user_role
 * @property boolean $remember
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property User $user
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiToken query()
 * @mixin \Eloquent
 */
class ApiToken extends Model
{
    use HasDTO;

    const TOKEN_EXPIRED_MINUTES = 60;

    protected $primaryKey = "token";

    public $incrementing = false;

    protected $fillable = [
        'token', 'ip', 'user_id', 'user_role', 'remember'
    ];

    protected static function boot()
    {
        static::retrieved(function (ApiToken $apiToken) {
            if ($apiToken->isTokenExpired())
                $apiToken->delete();
        });

        parent::boot();
    }

    public function isIpTokened()
    {
        return $this->ip !== null;
    }

    public function isRemembered()
    {
        return $this->remember ? true : false;
    }

    public function isTokenExpired()
    {
        return !$this->isRemembered() && Carbon::now()->diffInMinutes($this->updated_at) > static::TOKEN_EXPIRED_MINUTES;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        $model = null;
        switch ($this->user_role) {
            case User::ROLE_STUDENT:
                $model = Student::class;
                break;
            case User::ROLE_PROFESSOR:
                $model = Professor::class;
                break;
            case User::ROLE_ADMIN:
                $model = Admin::class;
                break;
            default:
                throw new \RuntimeException("Unhandled user role!");
        }
        return $this->hasOne($model, 'id', 'user_id');
    }

    public static function getDTOClass(): string
    {
        return ApiTokenDTO::class;
    }
}