<?php

namespace App\Policies;

use App\Enums\Test\Status;
use App\Models\Test;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class TestPolicy
{
    use HandlesAuthorization;

    public function create(User $currentUser, User $user): Response
    {
        return $currentUser->id === $user->id ? $this->allow() : $this->deny();
    }


    public function update(User $currentUser, User $user, Test $test): Response
    {
        if ($currentUser->id !== $user->id) {
            return $this->deny();
        }

        return match ($test->status) {
            Status::CREATED, Status::STARTED => $this->allow(),
            default => $this->deny(),
        };
    }
}
