<?php
namespace App\Http\Repository;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository {
    public static function createUser(array $credentials): User
    {
        $user = new User();
        $user->name = $credentials['name'];
        $user->password = Hash::make($credentials['password']);
        $user->email = $credentials['email'];
        $user->save();
        return $user;
    }

}
