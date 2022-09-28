<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[UsersController::class, 'index']);
Route::get('/users/datatable',[UsersController::class, 'datatable']);
Route::get('/users/create',[UsersController::class, 'create']);
Route::post('/users/store',[UsersController::class, 'create']);
Route::get('/users/edit/{id}',[UsersController::class, 'edit']);
Route::post('/users/update/{id}',[UsersController::class, 'edit']);
Route::get('/users/delete/{id}',[UsersController::class, 'destroy']);