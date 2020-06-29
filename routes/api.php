<?php

use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')
    ->group(function () {
        Route::resource('files', 'FilesController')
            ->only(['create', 'show', 'destroy']);
    });


Route::prefix('/guest')
    ->name('guest.')
    ->group(function () {

        /**
         * Return file (image) response to display by passed link token.
         */
        Route::get('files/{linkToken}', 'FilesController@link')->name('files.link');

    });
