<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

final class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $currentUser): Response
    {
        return $currentUser->admin ? $this->allow() : $this->deny();
    }

    public function view(User $currentUser, User $user): Response
    {
        if ($currentUser->admin) {
            return $this->allow();
        }

        return $currentUser->id === $user->id ? $this->allow() : $this->deny();
    }

    public function create(User $currentUser): Response
    {
        return $currentUser->admin ? $this->allow() : $this->deny();
    }

    public function update(User $currentUser, User $user): Response
    {
        if ($currentUser->admin) {
            return $this->allow();
        }

        return $currentUser->id === $user->id ? $this->allow() : $this->deny();
    }

    public function delete(): Response
    {
        return $this->deny();
    }
}
