<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{DashboardController,RecruitmentController,ScheduleController,EmployeeController,DepartmentController, SearchController, SupportTicketController,SettingController,AuthController};


// la route dashboard,
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');


// les routes principales
Route::get('/recruitments', function(){
    return view('recruitments.index');
})->name('recruitments.page');

Route::get('/employees', function(){
    return view('employees.index');
})->name('employee.page');

Route::get('/departments', function(){
    return view('departments.index');
})->name('departments.page');

Route::get('/settings', function(){
    return view('settings.index');
})->name('settings.page');

Route::get('/schedules', function(){
    return view('schedules.index');
})->name('schedules.page');

Route::get('/support', function(){
    return view('support.index');
})->name('support.page');

Route::get('/search', [SearchController::class, 'searchPage'])->name('search.page');

// les routes d'authentifications
// Route::get('/connexion', function(){
//     return view('auth.login');
// })->name('login.page');

// Route::get('/inscription', function(){
//     return view('auth.register');
// })->name('register.page');


