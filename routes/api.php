<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\EmployeeController;
use App\Http\Controllers\API\LeaveController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Auth routes
Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('/logout', 'logout');
        Route::get('/userDetails', 'userDetails');
    });
});
// protected Routes
Route::group(['middleware' => ['auth:sanctum', 'role']], function () {
    // Route::controller(EmployeeController::class)->group(function () {
    //     Route::get('/employee/index', 'index');
    //     Route::post('/employee/store', 'store');
    //     Route::get('/employee/edit/{id}', 'edit');
    //     Route::post('/employee/update/{id}', 'update');
    //     Route::post('/employee/delete/{id}', 'delete');
    // });
    // Route::controller(LeaveController::class)->group(function () {
    //     Route::get('/admin/leave/index', 'index');
    //     Route::post('/admin/leave/store', 'store');
    //     Route::get('/admin/leave/edit/{id}', 'edit');
    //     Route::post('/admin/leave/update/{id}', 'update');
    //     Route::post('/admin/leave/delete/{id}', 'delete');
    // });
});
Route::controller(EmployeeController::class)->group(function () {
    Route::get('/employee/index', 'index');
    Route::post('/employee/store', 'store');
    Route::get('/employee/edit/{id}', 'edit');
    Route::post('/employee/update/{id}', 'update');
    Route::post('/employee/delete/{id}', 'delete');
});

Route::controller(LeaveController::class)->group(function () {
    Route::get('/admin/leave/index', 'index');
    Route::post('/admin/leave/store', 'store');
    Route::get('/admin/leave/edit/{id}', 'edit');
    Route::post('/admin/leave/update/{id}', 'update');
    Route::post('/admin/leave/delete/{id}', 'delete');
    Route::post('/employee/leave/store', 'employeeLeave');
});
