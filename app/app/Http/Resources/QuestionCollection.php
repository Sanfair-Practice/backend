<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

class QuestionCollection extends ResourceCollection
{

    public function __construct($resource, private string $seed)
    {
        parent::__construct($resource);
    }

    protected function collectResource($resource)
    {
        $resources = parent::collectResource($resource);

        if ($resources instanceof Collection) {
            $resources->each->setSeed($this->seed);
        }

        return $resources;
    }
}
