<?php

namespace App\Models;

use App\Casts\DeletionDateCast;
use App\Casts\FileDescriptionCast;
use App\Casts\FileLocationCast;
use App\ValueObjects\DeletionDate\DeletionDate;
use App\ValueObjects\FileDescription;
use App\ValueObjects\FileLocation\FileLocation;
use Eloquent;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Carbon;

/**
 * App\Models\File
 *
 * @property int                             $id
 * @property int                             $user_id
 * @property FileLocation                    $location
 * @property FileDescription                 $description
 * @property DeletionDate                    $will_be_deleted_at
 * @method static EloquentBuilder|File newModelQuery()
 * @method static EloquentBuilder|File newQuery()
 * @method static EloquentBuilder|File query()
 * @method static EloquentBuilder|File whereDescription($value)
 * @method static EloquentBuilder|File whereId($value)
 * @method static EloquentBuilder|File whereUserId($value)
 * @method static EloquentBuilder|File whereWillBeDeletedAt($value)
 * @mixin Eloquent
 * @property-read Client                     $user
 * @method static EloquentBuilder|File overdue()
 * @method static EloquentBuilder|File whereFileName($value)
 * @method static EloquentBuilder|File whereStorage($value)
 * @property-read Collection|FileLinkToken[] $linkTokens
 * @property-read int|null                   $link_tokens_count
 * @property-read Collection|FileLinkToken[] $views
 * @property-read int|null                   $views_count
 * @method static EloquentBuilder|File wherePublicName($value)
 * @property Carbon|null                     $deleted_at
 * @method static QueryBuilder|File onlyTrashed()
 * @method static EloquentBuilder|File whereDeletedAt($value)
 * @method static QueryBuilder|File withTrashed()
 * @method static QueryBuilder|File withoutTrashed()
 * @property-read int|null                   $disposable_links_count
 * @property-read int|null                   $disposable_links_used_count
 * @property-read int|null                   $unlimited_link_views_count
 */
final class File extends Model
{
    use SoftDeletes;

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

    public function linkTokens()
    {
        return $this->hasMany(FileLinkToken::class);
    }

    public function views()
    {
        return $this->hasManyThrough(
            LinkVisit::class,
            FileLinkToken::class,
            'file_id',
            'link_token_id',
        );
    }

    /**
     * @param EloquentBuilder $query
     * @return EloquentBuilder
     */
    public function scopeOverdue(EloquentBuilder $query)
    {
        return $query->where('will_be_deleted_at', '<=', Carbon::now());
    }

    public function isOwnedBy(Client $user): bool
    {
        return $this->user_id === $user->id;
    }
}
