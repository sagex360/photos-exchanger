<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\LinkVisit
 *
 * @property int                $id
 * @property int                $link_token_id
 * @property Carbon|null        $created_at
 * @method static Builder|LinkVisit newModelQuery()
 * @method static Builder|LinkVisit newQuery()
 * @method static Builder|LinkVisit query()
 * @method static Builder|LinkVisit whereCreatedAt($value)
 * @method static Builder|LinkVisit whereId($value)
 * @method static Builder|LinkVisit whereLinkTokenId($value)
 * @property-read FileLinkToken $linkToken
 * @mixin Eloquent
 */
final class LinkVisit extends Model
{
    public const UPDATED_AT = null;

    public function linkToken(): BelongsTo
    {
        return $this->belongsTo(FileLinkToken::class, 'link_token_id');
    }
}
