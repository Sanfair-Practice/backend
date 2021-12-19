<?php

namespace App\Service;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Contracts\Hashing\Hasher;

class UserService
{
    public function __construct(private Hasher $hasher)
    {
    }

    public function create(CreateUserRequest $request): User
    {
        $user = User::make();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone = $request->phone;
        $user->passport = $this->hasher->make($request->passport);
        $user->password = $this->hasher->make($request->password);
        $user->email = $request->email;
        $user->save();

        return $user;
    }

    public function update(User $user, UpdateUserRequest $request): bool
    {
        return $user->update($request->validated());
    }
}
