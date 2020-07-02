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

Route::namespace('Files')
    ->group(function () {

        Route::middleware('auth:api')
            ->group(function () {
                Route::apiResource('files', 'FilesController')
                    ->only(['store', 'show', 'destroy']);

                Route::prefix('/files/{file}/')
                    ->name('files.')
                    ->group(function () {

                        Route::prefix('/relationships/')
                            ->name('relationships.')
                            ->group(function () {
                                Route::get('/user', 'FileRelationshipsController@user')->name('user');
                                Route::get('/link_tokens', 'FileRelationshipsController@linkTokens')->name('link_tokens');
                            });

                        Route::apiResource('link_tokens', 'FileLinkTokensController')
                            ->only('index');
                    });
            });

        Route::prefix('/guest')
            ->name('guest.')
            ->group(function () {

                /**
                 * Return file (image resource) by link token to display.
                 */
                Route::get('files/{linkToken}', 'FilesController@fileResource')->name('files.resource');
            });

    });

Route::apiResource('users', 'UsersController')
    ->only('show');

Route::apiResource('link_tokens', 'LinkTokens\LinkTokensController')
    ->only('show');
