<?php

use App\Http\Controllers\borrowingController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home.index');
Route::get('/adminPublish', function () {
    // Admin page
    return 'You are an admin';
})->middleware('role_or_permission:publish articles')->name('admin.publish');


Route::get('/userEdit', function(){
    // User page
    return 'You are a user';
})->middleware('role_or_permission:edit articles')->name('user.edit');


Route::get('/borrow', [borrowingController::class, 'index'])->name('borrow.borrow');