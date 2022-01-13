<?php
namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Repository\UserRepository;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();
        if(Auth::attempt($credentials, true)) {
            $user = User::select(['id', 'name'])->where('email', '=', $credentials['email'])->first();
            return new JsonResponse([
                'login' => $user->name,
                'id' => $user->id,
            ]);
        } else return new JsonResponse(['message' => 'Не удалось войти'], 403);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $credentials = $request->validated();
        if($credentials) {
            $newUser = UserRepository::createUser($credentials);
            return new JsonResponse([
                'id' => $newUser->id,
                'login' => $newUser->name
            ]);
        }
        return new JsonResponse(['message' => 'Не удалось зарегистрироваться.'], 422);
    }

    public function logout(): void
    {
        Auth::logout();
    }
}
