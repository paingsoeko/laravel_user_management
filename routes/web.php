<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RolesController;

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


Route::get('/', [AuthController::class, 'home'])->name('index');
Route::get('dashboard', [AuthController::class, 'home'])->name('home');


//----------------------------------- auth route  -----------------------------------
Route::post('/login',[AuthController::class, 'login'])->name('login');
Route::get('/logout',[AuthController::class, 'logout'])->name('logout');


//----------------------------------- user route  -----------------------------------
Route::resource('users', UsersController::class)->middleware('auth');
Route::get('/user/profile', [UsersController::class, 'showProfile'])->name('user.profile')->middleware('auth');
Route::post('/user/profile', [UsersController::class, 'uploadProfilePic'])->name('user.photo.upload')->middleware('auth');
Route::post('/user/profile/{id}', [UsersController::class, 'destroyProfilePic'])->name('user.profile.destroy')->middleware('auth');
Route::put('/user/password', [UsersController::class, 'updatePassword'])->name('user.password.update')->middleware('auth');


//----------------------------------- role route  -----------------------------------
Route::resource('roles', RolesController::class)->middleware('auth');


