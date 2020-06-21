<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final /**
 * App\Models\File
 *
 * @property int         $id
 * @property int         $user_id
 * @property string      $description
 * @property string|null $will_be_deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereWillBeDeletedAt($value)
 * @mixin \Eloquent
 */
class File extends Model
{
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
