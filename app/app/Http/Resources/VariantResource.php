<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Variant
 */
class VariantResource extends JsonResource
{
    public bool $preserveKeys = true;

    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'time' => $this->time,
            'end' => $this->end,
            'errors' => $this->errors,
            'input' => $this->input,
            'status' => $this->status,
            'test' => $this->test,
            'questions' => new QuestionCollection($this->whenLoaded('questions'), $this->seed),
        ];
    }
}
