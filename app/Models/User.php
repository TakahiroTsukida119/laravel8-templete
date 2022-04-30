<?php
declare(strict_types=1);

namespace App\Models;

use App\Notifications\ResetUserPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use JetBrains\PhpStorm\ArrayShape;
use Laravel\Sanctum\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

/**
 * ユーザー
 * Class User
 * @package App\Models
 */
class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $table = 'users';

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * @inheritDoc
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @inheritDoc
     */
    #[ArrayShape(['email' => "string"])]
    public function getJWTCustomClaims(): array
    {
        return [
            'email' => $this->email,
        ];
    }

    /**
     * パスワードリセットメール
     * @param $token
     * @return void
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetUserPassword($token));
    }
}
