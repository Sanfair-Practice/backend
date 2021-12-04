<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @mixin IdeHelperVariant
 */
class Variant extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class)->with(['tags', 'category']);
    }

    public function updateTimestamps()
    {
        parent::updateTimestamps();

        if (! $this->isDirty('end') && ! is_null($this->time)) {
            $this->end = $this->created_at->addMinutes($this->time);
        }
    }
}
