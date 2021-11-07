<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Chapter extends Model
{
    use HasFactory;

    public function sections(): BelongsToMany {
        return $this->belongsToMany(Section::class);
    }
}
