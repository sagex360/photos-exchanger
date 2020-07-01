<?php

namespace App\Models;

use App\Casts\LoginCast;
use App\Casts\NameCast;
use App\Casts\PasswordCast;
use App\ValueObjects\Login;
use App\ValueObjects\Name;
use App\ValueObjects\Password;
use Eloquent;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * App\Models\Client
 *
 * @property int                                                        $id
 * @property Name                                                       $name
 * @property Login                                                      $email
 * @property Carbon|null                                                $email_verified_at
 * @property Password                                                   $password
 * @property string|null                                                $remember_token
 * @property Carbon|null                                                $created_at
 * @property Carbon|null                                                $updated_at
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null                                              $notifications_count
 * @method static Builder|Client newModelQuery()
 * @method static Builder|Client newQuery()
 * @method static Builder|Client query()
 * @method static Builder|Client whereCreatedAt($value)
 * @method static Builder|Client whereEmail($value)
 * @method static Builder|Client whereEmailVerifiedAt($value)
 * @method static Builder|Client whereId($value)
 * @method static Builder|Client whereName($value)
 * @method static Builder|Client wherePassword($value)
 * @method static Builder|Client whereRememberToken($value)
 * @method static Builder|Client whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read Collection|File[]                                     $files
 * @property-read int|null                                              $files_count
 */
final class Client extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'api_token', 'remember_token',
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

    public function files()
    {
        return $this->hasMany(File::class, 'user_id');
    }
}
