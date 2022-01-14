<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        /*$credentials = $request->validated();
        if(Auth::attempt($credentials, true)) {
            $user = User::select(['id', 'name'])->where('email', '=', $credentials['email'])->first();
            return new JsonResponse([
                'login' => $user->name,
                'id' => $user->id,
            ]);
        } else return new JsonResponse(['message' => 'Не удалось войти'], 403);*/

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $response = ['token' => $token, 'login' => $user->name, 'id' => $user->id];
                return response($response, 200);
            } else {
                $response = ["message" => "Password mismatch"];
                return response($response, 422);
            }
        } else {
            $response = ["message" =>'User does not exist'];
            return response($response, 422);
        }
    }

    public function register(Request $request)
    {
        /*$credentials = $request->validated();
        if($credentials) {
            $newUser = UserRepository::createUser($credentials);
            return new JsonResponse([
                'id' => $newUser->id,
                'login' => $newUser->name
            ]);
        }
        return new JsonResponse(['message' => 'Не удалось зарегистрироваться.'], 422);*/

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $request['password']=Hash::make($request['password']);
        $request['remember_token'] = Str::random(10);
        $user = User::create($request->toArray());
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $response = ['token' => $token, 'login' => $user->name, 'id' => $user->id];
        return response($response, 200);
    }

    public function logout()
    {
        return Auth::logout();
    }
}
