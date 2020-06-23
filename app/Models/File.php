<?php

namespace App\Models;

use App\Casts\DeletionDateCast;
use App\Casts\FileDescriptionCast;
use App\Casts\FileLocationCast;
use App\ValueObjects\DeletionDate\DeletionDate;
use App\ValueObjects\FileDescription;
use App\ValueObjects\FileLocation\FileLocation;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\File
 *
 * @property int             $id
 * @property int             $user_id
 * @property FileLocation    $location
 * @property FileDescription $description
 * @property DeletionDate    $will_be_deleted_at
 * @method static Builder|File newModelQuery()
 * @method static Builder|File newQuery()
 * @method static Builder|File query()
 * @method static Builder|File whereDescription($value)
 * @method static Builder|File whereId($value)
 * @method static Builder|File whereUserId($value)
 * @method static Builder|File whereWillBeDeletedAt($value)
 * @mixin Eloquent
 * @property-read Client     $user
 * @method static Builder|File whereFileName($value)
 * @method static Builder|File whereStorage($value)
 */
final class File extends Model
{
    public $timestamps = false;

    protected $casts = [
        'location'           => FileLocationCast::class,
        'description'        => FileDescriptionCast::class,
        'will_be_deleted_at' => DeletionDateCast::class,
    ];

    public function user()
    {
        return $this->belongsTo(Client::class);
    }
}