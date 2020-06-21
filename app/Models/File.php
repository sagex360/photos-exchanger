<?php

namespace App\Models;

use App\Casts\DeletionDateCast;
use App\Casts\FileDescriptionCast;
use App\ValueObjects\FileDescription;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\File
 *
 * @property int             $id
 * @property int             $user_id
 * @property FileDescription $description
 * @property string|null     $will_be_deleted_at
 * @method static Builder|File newModelQuery()
 * @method static Builder|File newQuery()
 * @method static Builder|File query()
 * @method static Builder|File whereDescription($value)
 * @method static Builder|File whereId($value)
 * @method static Builder|File whereUserId($value)
 * @method static Builder|File whereWillBeDeletedAt($value)
 * @mixin \Eloquent
 */
final class File extends Model
{
    public $timestamps = false;

    protected $casts = [
        'description'        => FileDescriptionCast::class,
        'will_be_deleted_at' => DeletionDateCast::class,
    ];

    public function user()
    {
        return $this->belongsTo(Client::class);
    }
}
