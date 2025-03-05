<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;

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

Route::get('/register-view', [RegisterController::class, 'create'])->name('register.view');

Route::get('/', [DashboardController::class, 'index']);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
    Route::delete('/permissions', [PermissionController::class, 'destroy'])->name('permissions.destroy');
});

// require __DIR__."/auth.php";
