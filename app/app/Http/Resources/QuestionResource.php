<?php

namespace App\Http\Resources;

use App\Models\Question;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Question
 */
class QuestionResource extends JsonResource
{

    public function __construct(Question $resource, private ?string $seed)
    {
        parent::__construct($resource);
    }

    public function setSeed(string $seed): void
    {
        $this->seed = $seed;
    }

    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'rules' => $this->rules,
            'explanation' => $this->explanation,
            'choices' => $this->choices($this->seed),
        ];
    }
}
