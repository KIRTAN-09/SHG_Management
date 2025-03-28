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
use App\Http\Controllers\NotificationController;
use App\DataTables\GroupsDataTable;
use App\Http\Controllers\Forms\MemberReportController;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/reports/{type}', [ReportController::class, 'loadReportForm'])->name('reports.load');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home/savings-data', [App\Http\Controllers\HomeController::class, 'getSavingsData'])->name('home.savingsData');

Route::get('/reports/forms/members', function () {
    $members = \App\Models\Member::all(); // Fetch members from the database
    return view('reports.forms.members', compact('members'));
});

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
    Route::get('/reports/filter', [ReportController::class, 'filter'])->name('reports.filter');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::get('/api/groups/{groupId}/members', [GroupController::class, 'getMembersByGroup'])->name('groups.membersByGroup');
    Route::get('/api/groups/{group}/members', [GroupController::class, 'getMembers'])->name('groups.members');
    Route::get('/get-member-details', [MemberReportController::class, 'getMemberDetails']);
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
