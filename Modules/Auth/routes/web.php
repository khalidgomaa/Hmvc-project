<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\App\Http\Controllers\AuthController;

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

Route::group([], function () {
    Route::resource('auth', AuthController::class)->names('auth');
});




    Route::group(['middleware'=>'manger.guest'] , function(){
    Route::get('/login',[AuthController::class,'index'])->name('manger.login');
   
    Route::post('/authenticate',[AuthController::class,'authenticate'])->name('manger.authenticate');
   


    });
    
    Route::middleware('manger.auth')->group(function () {
    
        Route::get('/logout',[AuthController::class,'logout'])->name('manger.logout');
        
    });