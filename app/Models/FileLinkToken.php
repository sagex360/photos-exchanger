<?php

namespace App\Models;

use App\Casts\LinkTokenCast;
use App\ValueObjects\LinkToken\LinkToken;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\LinkToken
 *
 * @property int                         $id
 * @property int                         $file_id
 * @property LinkToken                   $token
 * @property Carbon|null                 $created_at
 * @property Carbon|null                 $updated_at
 * @property Carbon|null                 $deleted_at
 * @property-read Collection|LinkVisit[] $visits
 * @property-read int|null               $visits_count
 * @property string                      $type
 * @property-read File                   $file
 * @method static Builder|FileLinkToken newModelQuery()
 * @method static Builder|FileLinkToken newQuery()
 * @method static Builder|FileLinkToken query()
 * @method static Builder|FileLinkToken whereCreatedAt($value)
 * @method static Builder|FileLinkToken whereFileId($value)
 * @method static Builder|FileLinkToken whereId($value)
 * @method static Builder|FileLinkToken whereToken($value)
 * @method static Builder|FileLinkToken whereType($value)
 * @method static Builder|FileLinkToken whereUpdatedAt($value)
 * @mixin Eloquent
 * @method static \Illuminate\Database\Query\Builder|FileLinkToken onlyTrashed()
 * @method static Builder|FileLinkToken whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|FileLinkToken withTrashed()
 * @method static \Illuminate\Database\Query\Builder|FileLinkToken withoutTrashed()
 */
final class FileLinkToken extends Model
{
    use SoftDeletes;

    protected $table = 'link_tokens';

    protected $casts = [
        'token' => LinkTokenCast::class,
    ];

    public function visits()
    {
        return $this->hasMany(LinkVisit::class, 'link_token_id');
    }

    public function file()
    {
        return $this->belongsTo(File::class);
    }
}
