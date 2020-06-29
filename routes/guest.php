<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/view/files/')
    ->name('view.files.')
    ->group(function () {

        Route::get('/{token}', 'ViewFilesController@show')->name('show');
    });
