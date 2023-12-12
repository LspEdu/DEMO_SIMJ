<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\TypeEventController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/admin/users', [UserController::class, 'index'] )->name('users');

Route::post('/admin/users/create', [UserController::class,'store'])->name('user.create');
Route::post('/admin/users/update', [UserController::class,'update'])->name('user.update');
Route::delete('/admin/users/delete', [UserController::class,'destroy'])->name('user.destroy');

Route::post('/event/create', [EventController::class,'store'])->name('event.create');
Route::post('/event/update', [EventController::class,'update'])->name('event.update');
Route::delete('/event/delete', [EventController::class,'destroy'])->name('event.destroy');

Route::get('/event/get', [EventController::class,'index'])->name('event.index');

Route::get('/evento/tipo', [TypeEventController::class,'index'])->name('tipo.show');
Route::post('/evento/tipo/crear', [TypeEventController::class,'store'])->name('tipo.create');
Route::post('/evento/tipo/update', [TypeEventController::class,'update'])->name('tipo.update');
Route::delete('/evento/tipo/delete', [TypeEventController::class,'destroy'])->name('tipo.delete');

