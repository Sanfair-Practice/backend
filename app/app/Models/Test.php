<?php

namespace App\Models;

use App\Enums\Test\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Staudenmeir\EloquentHasManyDeep\HasManyDeep;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

/**
 * App\Models\Test
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $user_id
 * @property int $quantity
 * @property int $errors
 * @property int $time
 * @property string $status
 * @property string $type
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Chapter[] $chapters
 * @property-read int|null $chapters_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Section[] $sections
 * @property-read int|null $sections_count
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Variant[] $variants
 * @property-read int|null $variants_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Question[] $questions
 * @method static \Database\Factories\TestFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Test newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Test newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Test query()
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereErrors($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereUserId($value)
 * @mixin \Eloquent
 * @noinspection PhpFullyQualifiedNameUsageInspection
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
 */
class Test extends Model
{
    use HasFactory;
    use HasRelationships;

    protected $hidden = [
        'questions',
    ];

    protected $attributes = [
        'status' => Status::CREATED,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function variants(): BelongsToMany
    {
        return $this->belongsToMany(Variant::class);
    }

    public function sections(): BelongsToMany
    {
        return $this->belongsToMany(Section::class);
    }

    public function chapters(): BelongsToMany
    {
        return $this->belongsToMany(Chapter::class);
    }

    public function questions(): HasManyDeep
    {
        return $this->hasManyDeep(Question::class, [
            'section_test',
            Section::class,
            'question_section'
        ]);
    }

    public function updateStatus(): void
    {
        $this->status = $this->calculateStatus($this->status);
    }

    private function calculateStatus(string $default): string
    {
        if ($this->variants->some->isFailed()) {
            return Status::FAILED;
        }
        if ($this->variants->some->isExpired()) {
            return Status::EXPIRED;
        }
        if ($this->variants->every->isPassed()) {
            return Status::PASSED;
        }
        return $default;
    }
}
