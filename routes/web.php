<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserListController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if (!Auth::user()) {
        return view('auth.login');
    }
    return redirect()->route('home');
})->name('index');

Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login-post', [AuthController::class, 'loginPost'])->name('login.post');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register-post', [AuthController::class, 'registerPost'])->name('register.post');
});
Route::group(['middleware' => ['auth']], function () {

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/home', [HomeController::class, 'home'])->name('home');

    Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::post('fetch-user-edit', [UserController::class, 'fetchUserEdit'])->name('fetch.user.edit');
        Route::post('store', [UserController::class, 'store'])->name('store');
        Route::post('delete', [UserController::class, 'delete'])->name('delete');
    });

    Route::group(['prefix' => 'user-lists', 'as' => 'user-lists.'], function () {
        Route::get('/', [UserListController::class, 'index'])->name('index');
    });

    Route::get('stripe', [StripeController::class, 'index'])->name('stripe');
    Route::post('payment-process', [StripeController::class, 'process'])->name('payment.process');
});
