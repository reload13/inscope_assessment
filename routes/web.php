<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//TODO: Add EnumRoleMiddleware for passing enums in 'middleware' => 'role:admin'
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'role:admin'], function () {
    Route::resource('companies', CompanyController::class)->names('companies');
});

Route::get('select-company', [CompanyController::class, 'selectCompany'])->name('select-company')->middleware('auth');

Route::middleware(['role:admin|moderator', 'company.access'])
    ->prefix('{company:slug}')
    ->group(function () {
        Route::get('/', [CompanyController::class,"userDashboard"])->name('userDashboard');
        Route::resource('users', UserController::class)->names('users');
        Route::resource('projects', ProjectController::class)->names('projects');
    });

