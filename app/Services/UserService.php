<?php
namespace App\Services;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Services\Interface\UserInterface;

class UserService implements UserInterface
{
    /**
     * Create a new user.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \App\Models\User
     */
    public function createUser(StoreUserRequest $request): User
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