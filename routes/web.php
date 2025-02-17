<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login-view', [AuthController::class, "login_view"])->name('login-view');

Route::post('/login', [AuthController::class, 'login_web']);

Route::post('/register', [AuthController::class, 'register_user'])->name('register-method');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



Route::middleware(["check.session", "is_admin", "no.cache" ])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });
});

Route::middleware(["check.session", "no.cache"])->group(function () {
    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    });
});



Route::get('/register-view', function () {
    return view('auth.register');
})->name('register-view');



Route::get('/', function () {
    return redirect('/login-view');
});

