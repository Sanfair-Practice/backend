<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Test
 */
class TestResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'errors' => $this->errors,
            'quantity' => $this->quantity,
            'time' => $this->time,
            'type' => $this->type,
            'status' => $this->status,
            'created' => $this->created_at,
            'sections' => SectionResource::collection($this->whenLoaded('sections')),
            'chapters' => ChapterResource::collection($this->whenLoaded('chapters')),
            'variants' => VariantResource::collection($this->whenLoaded('variants')),
            'user' => UserResource::make($this->whenLoaded('user')),
        ];
    }
}
