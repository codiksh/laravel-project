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

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    return view('admin.dashboard.index');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
require __DIR__.'/media.php';

Route::group(['prefix' => 'admin',
    'middleware' => ['auth',
        'role:Super Admin'],], function(){
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class, ["as" => 'admin']);
    Route::group(['prefix' => 'users', 'as' => 'admin.users.'], function () {
        Route::group(['prefix' => '{user}/change-password', 'as' => 'changePassword.'], function (){
            Route::get('/', [\App\Http\Controllers\Admin\UserController::class, 'changePassword'])->name('index');
            Route::post('process', [\App\Http\Controllers\Admin\UserController::class, 'changePassword_process'])->name('process');
        });
    });

    Route::group(['prefix'=>'user-tokens/{user}', 'as'=>'admin.userTokens.'], function() {
        Route::get('index', [\App\Http\Controllers\Admin\UserTokenController::class, 'index'])->name('index');
        Route::post('generate', [\App\Http\Controllers\Admin\UserTokenController::class, 'generate'])->name('generate');
        Route::delete('destroy/{token}', [\App\Http\Controllers\Admin\UserTokenController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'file', 'as' => 'file.'], function() {
        Route::post('upload-media', [\App\Http\Controllers\Admin\UploadMediaController::class , 'uploadMedia'])->name('upload');
        Route::post('remove-media', [\App\Http\Controllers\Admin\UploadMediaController::class , 'removeMedia'])->name('remove');
    });
});
