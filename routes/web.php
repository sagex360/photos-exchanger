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
        Route::get('/login', 'LoginController@showLoginForm')
            ->middleware('guest')
            ->name('login');

        Route::post('/login', 'LoginController@login')
            ->name('login.perform');

        Route::get('/register', 'RegisterController@showRegistrationForm')
            ->middleware('guest')
            ->name('register');

        Route::post('/register', 'RegisterController@register')
            ->name('register.perform');

        Route::post('/logout', 'LoginController@logout')
            ->name('logout.perform');
    });

Route::prefix('/dashboard')
    ->name('dashboard.')
    ->namespace('Dashboard')
    ->middleware('auth:web')
    ->group(function () {

        Route::get('/files/reports', 'ReportsController@index')->name('files.reports.index');

        Route::resource('files', 'FilesController')
            ->only(['create', 'show', 'edit', 'update', 'destroy', 'store', 'index']);

        Route::prefix('files/{file}/')
            ->group(function () {
                Route::resource('links', 'LinksController')
                    ->only('index', 'create', 'store', 'destroy');
            });

        Route::get('/', 'HomeController@index')->name('home');
    });

Route::redirect('/', '/login');
