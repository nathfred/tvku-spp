<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DirectorController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AssignmentController;

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

Route::get('/home', [UserController::class, 'home'])->name('home');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::group(['middleware' => ['auth', 'director'], 'prefix' => 'director'], function () {
    Route::get('/index', [DirectorController::class, 'index'])->name('director-index'); // INDEX

    // READ
    Route::get('/assignment/show', [DirectorController::class, 'show_assignments'])->name('director-show-assignments'); // ALL (TABLE)
    Route::get('/assignment/show', [DirectorController::class, 'show_assignment'])->name('director-show-assignment'); // SINGLE (FORM)

    // PRIORITY
    Route::get('/assignment/priority/{id}/{priority}', [AssignmentController::class, 'priority_assignment'])->name('director-priority-assignment'); // SET ASSIGNMENT PRIORITY (BIASA/PENTING/SANGAT)

    // APPROVE
    Route::get('/assignment/approve/{id}/{approve}', [AssignmentController::class, 'approve_assignment'])->name('director-approve-assignment'); // SET ASSIGNMENT APPROVAL (BOOLEAN)
});

Route::group(['middleware' => ['auth', 'employee'], 'prefix' => 'employee'], function () {
    Route::get('/index', [EmployeeController::class, 'index'])->name('employee-index'); // INDEX

    // READ
    Route::get('/assignment/show', [AssignmentController::class, 'show_assignments'])->name('employee-show-assignments'); // ALL (TABLE)

    // FORM CREATE & STORE
    Route::get('/assignment/pre-create', [AssignmentController::class, 'pre-create_assignment'])->name('employee-pre-create-assignment'); // SELECT ASSIGNMENT TYPE
    Route::get('/assignment/create/{type}', [AssignmentController::class, 'create_assignment'])->name('employee-create-assignment'); // CREATE ASSIGNMENT (FORM)
    Route::post('/assignment/create/{type}', [AssignmentController::class, 'store_assignment'])->name('employee-store-assignment'); // STORE CREATED ASSIGNMENT

    // FORM EDIT & STORE
    Route::get('/assignment/edit/{type}/{id}', [EmployeeController::class, 'edit_assignment'])->name('employee-edit-assignment'); // EDIT ASSIGNMENT (FORM)
    Route::post('/assignment/save/{type}/{id}', [EmployeeController::class, 'save_assignment'])->name('employee-save-assignment'); // SAVE EDITED ASSIGNMENT

    // DELETE
    Route::get('/assignment/delete/{id}', [EmployeeController::class, 'delete_assignment'])->name('employee-delete-assignment'); // DELETE ASSIGNMENT

    // SUBMIT
    Route::get('/assignment/submit/{submit}/{id}', [EmployeeController::class, 'submit_assignment'])->name('employee-submit-assignment'); // SUBMIT ASSIGNMENT (BOOLEAN)
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/pdf/free/{id}', [PDFController::class, 'createPDF_free'])->name('create-pdf-free');
    Route::get('/pdf/paid/{id}', [PDFController::class, 'createPDF_paid'])->name('create-pdf-paid');
    Route::get('/pdf/swap/{id}', [PDFController::class, 'createPDF_swap'])->name('create-pdf-swap');
});

Route::group(['middleware' => ['auth', 'employee'], 'prefix' => 'employee'], function () {
    // Route::get('/index', [EmployeeController::class, 'index'])->name('employee-index'); // INDEX

    // // READ
    // Route::get('/assignment/show', [AssignmentController::class, 'show_assignments'])->name('employee-show-assignments'); // ALL (TABLE)

    // // FORM CREATE & STORE
    // Route::get('/assignment/pre-create', [AssignmentController::class, 'pre-create_assignment'])->name('employee-pre-create-assignment'); // SELECT ASSIGNMENT TYPE
    // Route::get('/assignment/create/free', [AssignmentController::class, 'create_assignment_free'])->name('employee-create-assignment-free'); //
    // Route::post('/assignment/create/free', [AssignmentController::class, 'store_assignment_free'])->name('employee-store-assignment-free');
    // Route::get('/assignment/create/paid', [AssignmentController::class, 'create_assignment_paid'])->name('employee-create-assignment-paid');
    // Route::post('/assignment/create/paid', [AssignmentController::class, 'store_assignment_paid'])->name('employee-store-assignment-paid');
    // Route::get('/assignment/create/swap', [AssignmentController::class, 'create_assignment_swap'])->name('employee-create-assignment-swap');
    // Route::post('/assignment/create/swap', [AssignmentController::class, 'store_assignment_swap'])->name('employee-store-assignment-swap');

    // // FORM EDIT & STORE
    // Route::get('/assignment/edit/free/{id}', [EmployeeController::class, 'edit_assignment_free'])->name('employee-edit-assignment-free');
    // Route::post('/assignment/save/free/{id}', [EmployeeController::class, 'save_assignment_free'])->name('employee-save-assignment-free');
    // Route::get('/assignment/edit/paid/{id}', [EmployeeController::class, 'edit_assignment_paid'])->name('employee-edit-assignment-paid');
    // Route::post('/assignment/save/paid/{id}', [EmployeeController::class, 'save_assignment_paid'])->name('employee-save-assignment-paid');
    // Route::get('/assignment/edit/swap/{id}', [EmployeeController::class, 'edit_assignment_swap'])->name('employee-edit-assignment-swap');
    // Route::post('/assignment/save/swap/{id}', [EmployeeController::class, 'save_assignment_swap'])->name('employee-save-assignment-swap');

    // // DELETE
    // Route::get('/assignment/delete/{id}', [EmployeeController::class, 'delete_assignment'])->name('employee-delete-assignment');
});

require __DIR__ . '/auth.php';
