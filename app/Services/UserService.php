<?php
namespace App\Services;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;

class UserService
{
    public function create_user(StoreUserRequest $request)
    {
        $user = User::create([
            'name'     =>   $request->name,
            'email'    =>   $request->email,
            'password' =>   bcrypt($request->password),
        ]);

        // Your shared logic here
        return $user;
    }
}
