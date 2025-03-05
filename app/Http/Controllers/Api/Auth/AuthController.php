<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Services\UserService;
use App\Services\RoleRedirector;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    protected $userService;

    protected $authService;

    public function __construct(UserService $userService, AuthService $authService)
    {
        $this->userService = $userService;
        $this->authService = $authService;
        $this->middleware('auth:api', ['except' => ['login']]);

    }

     /**
     * Login and generate an API token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $token = auth()->attempt($request->validated());

        if($token) {
            return $this->responseWithToken($token, auth()->user());
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Invalid credentials'
            ], 401);
        }
        // // Validate the incoming request data
        // $validator = Validator::make($request->all(), [
        //     'email'    => 'required|email',
        //     'password' => 'required|string|min:6',
        //     'site' => 'required|in:user,admin',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json([
        //         'message' => 'Validation error',
        //         'errors'  => $validator->errors()
        //     ], 422);
        // }

        // // Check if the user exists and the password matches
        // $user = User::where('email', $request->email)->first();

        // if (!$user || !Hash::check($request->password, $user->password)) {
        //     return response()->json([
        //         'message' => 'Invalid user or password',
        //         'status' => 401
        //     ], 401);
        // }

        // if(!$user->email_verified_at){
        //     return response()->json([
        //         'message' => 'user not verify yet!!',
        //         'status' => 401
        //     ], 401);
        // }

        // if ($request->site == 'admin' && !$user->role =='admin') {
        //     return response()->json(['error' => 'You are not authorized as admin'], 403);
        // }

        // // Revoke all previous tokens to implement single login
        // $user->tokens->each(function ($token) {
        //     $token->delete();
        // });
        
        // // Generate an API token using Sanctum
        // $token = $user->createToken('API Token')->plainTextToken;

        // return response()->json([
        //     'message' => 'Login successful',
        //     'token'   => $token,
        // ]);
    }

    public function responseWithToken($token, $user){
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'access_token' => $token,
        ]);
    }

    // Return authenticated user
    public function me()
    { 
        $user = $this->authService->user();
        return response()->json($user);
    }

    // Handle user logout (revoke current token)
    public function logout(Request $request)
     {
        // Revoke the current token
        $request->user()->tokens->each(function ($token) {
            $token->delete();
        });
 
         return response()->json(['message' => 'Logged out successfully']);
    }

    public function loginView()
    {
        return view("auth.login");
    }

    public function loginWeb(Request $request)
    {
        $loginStatus = $this->authService->login($request->email, $request->password);
        
        if ($loginStatus) {
            $roleRedirector = new RoleRedirector();
            $user = $this->authService->user();
            $redirectPath = $roleRedirector->getRedirectPath($user);
            return redirect()->intended($redirectPath);
        }
        throw ValidationException::withMessages([
            "Error" => "User or password not invalid"
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function registerUser(StoreUserRequest $request)
    {
        $result = $this->userService->create_user($request);

        try {
            return redirect()->route('login.view')->with("error", "Email or password not avalible");
        } catch (\Throwable $th) {
            //throw $th;
        }
    }


    /**
     * Log out the user and clear authentication.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logoutView(Request $request)
    {
        $this->authService->logout();

        // Invalidate the user's session
        $request->session()->invalidate();
 
        // Regenerate the CSRF token to prevent CSRF attacks
        $request->session()->regenerateToken();

        return redirect()->route('login.view')->with('status', 'You have been logged out!');
    }

}
