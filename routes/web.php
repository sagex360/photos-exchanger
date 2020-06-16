<?php

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

Route::namespace('Auth')
    ->name('auth.')
    ->group(function () {
        Route::get('/login', 'LoginController@showLoginForm')->name('login');

        Route::get('/register', 'RegisterController@showRegistrationForm')->name('register');

    });

Route::prefix('/dashboard')
    ->name('dashboard.')
    ->namespace('Dashboard')
    ->group(function () {

        Route::resource('files', 'FilesController')
            ->only(['create', 'edit', 'update', 'destroy', 'store', 'index']);

        Route::get('/', 'HomeController@index')->name('home');
    });

Route::redirect('/', '/login');
