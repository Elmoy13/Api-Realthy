<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::controller(AuthController::class)->group(function () {

    Route::post('/register', 'register');
    Route::post('/login', 'login')->name('login');

});

Route::middleware('auth:sanctum')->group(function(){
Route::middleware('auth:sanctum')->delete('/logout', [AuthController::class, 'logout']);
Route::get('/refresh', [AuthController::class,'refresh']);
Route::get('/users/show', [UsersController::class,'showAll']);
Route::get('/users/show/{id}', [UsersController::class,'showById']);
Route::get('/users/branch/{id}', [UsersController::class,'showUsersByBranch']);
Route::put('/users/update/{id}', [UsersController::class,'update']);
Route::put('/users/update/password/{id}', [UsersController::class,'updatePasswordReset']);
Route::delete('/users/delete/{id}', [UsersController::class,'delete']);



});
