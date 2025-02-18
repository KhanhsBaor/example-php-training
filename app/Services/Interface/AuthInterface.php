<?php

namespace App\Services\Interface;

interface AuthInterface
{
    /**
     * Attempt to login a user with credentials.
     *
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function login(string $email, string $password): bool;

    /**
     * Check if the user is authenticated.
     *
     * @return bool
     */
    public function check(): bool;

    /**
     * Get the currently authenticated user.
     *
     * @return \App\Models\User|null
     */
    public function user();

    /**
     * Logout the currently authenticated user.
     *
     * @return void
     */
    public function logout();
}