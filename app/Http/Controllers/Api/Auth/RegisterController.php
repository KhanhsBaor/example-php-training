<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
 
    public function create(): View
    {
        return view('auth.register');
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

}
