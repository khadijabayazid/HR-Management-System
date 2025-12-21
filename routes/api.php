<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\JobTitleController;
use App\Http\Controllers\SystemSettingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function() {
    
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('me', [AuthController::class, 'me']);

    Route::apiResource('departments', DepartmentController::class);
    Route::apiResource('jobTitles', JobTitleController::class);
    Route::apiResource('employees', EmployeeController::class);
    Route::apiResource('attendances', AttendanceController::class);

    Route::get('settings', [SystemSettingController::class, 'index']);
    Route::put('settings/{key}', [SystemSettingController::class, 'update']);
    
});