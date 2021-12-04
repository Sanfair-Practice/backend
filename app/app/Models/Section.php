<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @mixin IdeHelperSection
 */
class Section extends Model
{
    use HasFactory;

    public function questions(): BelongsToMany {
        return $this->belongsToMany(Question::class);
    }
}
