<?php

namespace App\Http\Resources;

use App\Models\User;

class LoggedUserResource extends UserResource
{
    public function __construct(User $resource, private string $token)
    {
        parent::__construct($resource);
    }

    public function toArray($request): array
    {
        $result = [
            'token' => $this->token,
        ];
        return parent::toArray($request) + $result;
    }
}
