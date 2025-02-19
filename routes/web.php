<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;

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

Route::get('/login', [AuthController::class, "loginView"])->name('login.view');

Route::post('/login', [AuthController::class, 'loginWeb'])->name('login.method');
Route::post('/register', [AuthController::class, 'registerUser'])->name('register.method');
Route::post('/logout', [AuthController::class, 'logoutView'])->name('logout.method');


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
})->name('register.view');

Route::get('/', [DashboardController::class, 'index']);

