<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\SavingsController;
use App\Http\Controllers\IGAController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home/savings-data', [App\Http\Controllers\HomeController::class, 'getSavingsData'])->name('home.savingsData');

Route::group(['middleware' => ['auth']], function() {
Route::resource('roles', RoleController::class);
Route::resource('users', UserController::class);
Route::resource('members', MemberController::class);
 
Route::get('/members', [MemberController::class, 'index'])->name('members.index');
Route::resource('groups', HomeController::class);
Route::resource('groups', GroupController::class);
Route::resource('savings', SavingsController::class);
Route::resource('igas', IGAController::class);
Route::resource('training', TrainingController::class);
Route::resource('meetings', MeetingController::class);
Route::resource('reports', ReportController::class);
Route::get('/roles/{id}/json', [RoleController::class, 'showJson'])->name('roles.showJson');
// Route::get('/igas/activities', [IGAController::class, 'activities'])->name('igas.activities');
// Route::get('/members/{id}', [MemberController::class, 'show'])->name('members.show');
Route::get('/reports/filter', [ReportController::class, 'filter'])->name('reports.filter');
});