<?php

use Illuminate\Support\Facades\Route;
use Modules\Employee\App\Http\Controllers\EmployeeController;
use Modules\Employee\App\Http\Controllers\TempImagesController;


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
    Route::resource('employee', EmployeeController::class)->names('employee');
});
Route::post('/upload-temp.image',[TempImagesController::class,'create'])->name('temp-image.create');



Route::middleware('manger.auth')->group(function () {
    Route::get('/dashboard', [EmployeeController::class, 'index'])->name('manger.dashboard');
    
});
