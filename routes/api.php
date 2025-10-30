<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{DashboardController,RecruitmentController,ScheduleController,EmployeeController,DepartmentController, SearchController, SupportTicketController,SettingController};

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// La route dasboard
Route::get('/dashboard', [DashboardController::class, 'stats']);

// les routes principales

Route::apiResource('employees', EmployeeController::class);
Route::apiResource('departments', DepartmentController::class);
Route::apiResource('recruitments', RecruitmentController::class);
Route::apiResource('schedules', ScheduleController::class);
Route::apiResource('support', SupportTicketController::class);
Route::apiResource('settings', SettingController::class);

Route::get('/search/global', [SearchController::class, 'globalSearch']);


