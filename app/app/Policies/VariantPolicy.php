<?php

namespace App\Policies;

use App\Enums\Variant\Status;
use App\Models\User;
use App\Models\Variant;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class VariantPolicy
{
    use HandlesAuthorization;

    public function view(User $currentUser, Variant $variant): Response
    {
        return $variant->status === Status::CREATED ? $this->deny() : $this->allow();
    }

    public function update(User $currentUser, User $user, Variant $variant): Response
    {
        if ($currentUser->id !== $user->id) {
            return $this->deny();
        }

        return match ($variant->status) {
            Status::CREATED => $this->allow(),
            default => $this->deny(),
        };
    }

    public function answer(User $currentUser, User $user, Variant $variant): Response
    {
        if ($currentUser->id !== $user->id) {
            return $this->deny();
        }

        return match ($variant->status) {
            Status::STARTED => $this->allow(),
            default => $this->deny(),
        };
    }
}
