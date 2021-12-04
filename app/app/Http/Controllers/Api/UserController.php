<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $users = User::all();
        return UserResource::collection($users)->toResponse($request);
    }

    public function store(CreateUserRequest $request, Hasher $hasher): JsonResponse
    {
        $validated = $request->validated();
        $user = User::make();
        $user->first_name = $validated['first_name'];
        $user->last_name = $validated['last_name'];
        $user->phone = $validated['phone'];
        $user->passport = $hasher->make($validated['passport']);
        $user->password = $hasher->make($validated['password']);
        $user->email = $validated['email'];
        $user->save();
        return (new UserResource($user))->toResponse($request);
    }

    public function show(Request $request, User $user): JsonResponse
    {
        return (new UserResource($user))->toResponse($request);
    }

    public function edit(Request $request, User $user): JsonResponse
    {
        return (new UserResource($user))->toResponse($request);
    }

    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $user->update($request->validated());
        return (new UserResource($user))->toResponse($request);
    }
}
