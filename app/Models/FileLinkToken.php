<?php

namespace App\Models;

use App\Casts\LinkTokenCast;
use App\ValueObjects\LinkToken\LinkToken;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public function visits(): HasMany
    {
        return $this->hasMany(LinkVisit::class, 'link_token_id');
    }

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }

    protected function visitsCount(): int
    {
        return $this->visits_count;
    }

    public function link(): string
    {
        return route('guest.view.files.show', $this->token->token());
    }

    public function statusReadable(): string
    {
        $visitsCount = $this->visitsCount();

        return sprintf(
            trans("texts.entities.link-token.status.{$this->token->status($visitsCount)}"),
            $visitsCount
        );
    }

    public function typeReadable(): string
    {
        return trans("texts.entities.link-token.types.{$this->token->type()}");
    }

    public function expired(): bool
    {
        return $this->token->expired($this->visitsCount());
    }
}
