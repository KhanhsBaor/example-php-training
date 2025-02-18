<?php
namespace App\Services\Interface;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;

interface UserInterface 
{
    /**
     * Create a new user.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \App\Models\User
     */
    public function createUser(StoreUserRequest $request): User;
}