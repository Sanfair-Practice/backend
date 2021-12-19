<?php

namespace App\Models;

use App\Enums\Variant\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Variant
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $seed
 * @property int $time
 * @property \Illuminate\Support\Carbon|null $end
 * @property int $errors
 * @property array $input
 * @property int $test_id
 * @property string $status
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Question[] $questions
 * @property-read int|null $questions_count
 * @property-read \App\Models\Test $test
 * @method static \Database\Factories\VariantFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Variant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Variant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Variant query()
 * @method static \Illuminate\Database\Eloquent\Builder|Variant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Variant whereEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Variant whereErrors($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Variant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Variant whereInput($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Variant whereSeed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Variant whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Variant whereTestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Variant whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Variant whereUpdatedAt($value)
 * @mixin \Eloquent
 * @noinspection PhpFullyQualifiedNameUsageInspection
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
 */
class Variant extends Model
{
    use HasFactory;

    protected $attributes = [
        'status' => Status::CREATED,
    ];

    protected $casts = [
        'end' => 'datetime',
        'input' => 'array',
    ];

    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }

    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class);
    }

    public function updateTimestamps(): void
    {
        parent::updateTimestamps();

        if ($this->status === Status::STARTED && is_null($this->end) && ! is_null($this->updated_at)) {
            $this->end = $this->updated_at->addMinutes($this->time);
        }
    }

    public function getChoicesFor(Question $question): array
    {
        return array_keys($this->choicesFor($question));
    }

    public function submitAnswer(Question $question, string $answer): void
    {
        $choices = $this->choicesFor($question);

        $input = $this->input;

        $input[$question->id] ??= [
            'submitted' => $answer,
            'correct' => $question->getAnswer($this->seed),
            'value' => $choices[$answer] ?? '[unknown]',
        ];

        $this->input = $input;
    }

    public function updateStatus(): void
    {
        $this->status = $this->calculateStatus($this->status);
    }

    public function isFailed(): bool
    {
        return $this->status === Status::FAILED;
    }

    public function isPassed(): bool
    {
        return $this->status === Status::PASSED;
    }

    public function isExpired(): bool
    {
        return $this->status === Status::EXPIRED;
    }

    private function choicesFor(Question $question): array
    {
        return $question->choices($this->seed);
    }

    private function calculateStatus(string $default): string
    {
        $errors = 0;
        foreach ($this->input as $answer) {
            if ($answer['submitted'] !== $answer['correct']) {
                ++$errors;
            }
            if ($errors >= $this->errors && $this->errors > 0) {
                return Status::FAILED;
            }
        }

        $this->loadCount('questions');
        if (count($this->input) === $this->questions_count) {
            return Status::PASSED;
        }
        return $default;
    }
}
