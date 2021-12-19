<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\LoggedUserResource;
use App\Models\User;
use App\Service\UserService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Factory as AuthManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    /**
     * @throws AuthenticationException
     */
    public function status(Request $request, AuthManager $authManager): LoggedUserResource
    {
        $user = $authManager->guard()->user();
        if (! $user instanceof User) {
            throw new AuthenticationException('Unauthenticated.');
        }
        return LoggedUserResource::make($user, $request->bearerToken());
    }

    /**
     * @throws AuthenticationException
     */
    public function login(LoginRequest $request, AuthManager $authManager): LoggedUserResource
    {
        $credentials = ['email' => $request->email, 'password' => $request->password];
        if (! $authManager->guard()->attempt($credentials)) {
            throw new AuthenticationException('Unauthenticated.');
        }

        $user = $authManager->guard()->user();
        if (! $user instanceof User) {
            throw new AuthenticationException('Unauthenticated.');
        }

        $token = $user->createToken($request->device)->plainTextToken;

        return LoggedUserResource::make($user, $token);
    }

    /**
     * @throws AuthenticationException
     */
    public function logout(AuthManager $authManager): void
    {
        $user = $authManager->guard()->user();
        if (! $user instanceof User) {
            throw new AuthenticationException('Unauthenticated.');
        }
        $token = $user->currentAccessToken();
        if ($token instanceof Model) {
            $token->delete();
        }
    }

    public function register(RegisterRequest $request, UserService $userService): LoggedUserResource
    {
        $user = $userService->create($request);

        $token = $user->createToken($request->device)->plainTextToken;

        return LoggedUserResource::make($user, $token);
    }
}
