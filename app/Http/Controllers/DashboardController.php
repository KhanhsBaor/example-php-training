<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Services\RoleRedirector;

class DashboardController extends Controller
{
    protected $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function index()
    {
        // Check if user is logged in
        if ( $this->authService->check()) {
            $roleRedirector = new RoleRedirector();
            $user = $this->authService->user();
            $redirectPath = $roleRedirector->getRedirectPath($user);
            return redirect()->intended($redirectPath);
        }

        // If not logged in, redirect to the login page
        return redirect()->route('login.view');
    }

    public function userDasboardView()
    {

    }
}
