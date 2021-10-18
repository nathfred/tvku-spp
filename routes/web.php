<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DirectorController;
use App\Http\Controllers\EmployeeController;

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

Route::get('/home', [UserController::class, 'home']);
Route::get('/logout', [UserController::class, 'logout']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::group(['middleware' => ['auth', 'director'], 'prefix' => 'director'], function () {
    Route::get('/index', [DirectorController::class, 'index'])->name('director-index');
});

Route::group(['middleware' => ['auth', 'employee'], 'prefix' => 'employee'], function () {
    Route::get('/index', [EmployeeController::class, 'index'])->name('employee-index');
});

require __DIR__ . '/auth.php';
