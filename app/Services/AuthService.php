<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Services\Interface\AuthInterface;

class AuthService implements AuthInterface
{
    /**
     * Attempt to login a user with credentials.
     *
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function login(string $email, string $password): bool
    {
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            // If login is successful
            return true;
        }

        // If login fails
        return false;
    }

    /**
     * Check if the user is authenticated.
     *
     * @return bool
     */
    public function check(): bool
    {
        return Auth::check();
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \App\Models\User|null
     */
    public function user()
    {
        return Auth::user();
    }

    /**
     * Logout the currently authenticated user.
     *
     * @return void
     */
    public function logout()
    {
         // Log the user out
         Auth::logout();
    }
}
