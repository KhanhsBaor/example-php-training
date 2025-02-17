<?php

namespace App\Services;

use App\Models\User;

class RoleRedirector
{
    /**
     * Xác định đường dẫn chuyển hướng dựa trên vai trò của người dùng.
     *
     * @param  \App\Models\User  $user
     * @return string
     */
    public function getRedirectPath(User $user): string
    {
        if ($user->role === 'admin') {
            return '/admin/dashboard';
        }

        return '/user/dashboard';
    }
}
