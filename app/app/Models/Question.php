<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\MediaLibrary\InteractsWithMedia;

class Question extends Model
{
    use HasFactory;
    use InteractsWithMedia;

    protected $casts = [
        'dummy' => 'array',
    ];

    public function category(): BelongsTo {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany {
        return $this->belongsToMany(Tag::class);
    }
}
