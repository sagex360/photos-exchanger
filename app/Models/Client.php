<?php

namespace App\Models;

use App\Casts\LoginCast;
use App\Casts\NameCast;
use App\Casts\PasswordCast;
use App\ValueObjects\Login;
use App\ValueObjects\Name;
use App\ValueObjects\Password;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * App\Models\Client
 *
 * @property int $id
 * @property Name $name
 * @property Login $email
 * @property Carbon|null $email_verified_at
 * @property Password $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static Builder|\App\Models\Client newModelQuery()
 * @method static Builder|\App\Models\Client newQuery()
 * @method static Builder|\App\Models\Client query()
 * @method static Builder|\App\Models\Client whereCreatedAt($value)
 * @method static Builder|\App\Models\Client whereEmail($value)
 * @method static Builder|\App\Models\Client whereEmailVerifiedAt($value)
 * @method static Builder|\App\Models\Client whereId($value)
 * @method static Builder|\App\Models\Client whereName($value)
 * @method static Builder|\App\Models\Client wherePassword($value)
 * @method static Builder|\App\Models\Client whereRememberToken($value)
 * @method static Builder|\App\Models\Client whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Client extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'name'     => NameCast::class,
        'email'    => LoginCast::class,
        'password' => PasswordCast::class,

        'email_verified_at' => 'datetime',
    ];
}
