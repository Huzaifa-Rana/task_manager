<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskCommentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

// Admin routes (accessible only by admin)
Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/admin/users/{user}/change-role', [AdminController::class, 'changeRole'])->name('admin.changeRole');
});

// Manager routes (accessible only by manager)
Route::group(['middleware' => ['role:manager']], function () {
    Route::get('/manager/dashboard', [ManagerController::class, 'dashboard'])->name('manager.dashboard');
    Route::get('/manager/tasks', [ManagerController::class, 'tasks'])->name('manager.tasks');
});

// User routes (for regular users)
Route::group(['middleware' => ['role:user']], function () {
    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/user/tasks', [UserController::class, 'tasks'])->name('user.tasks');
});

// Extra features routes (must be defined before resource routes)
Route::get('/tasks/search', [TaskController::class, 'search'])->name('tasks.search');
Route::get('/tasks/timeline/data', [TaskController::class, 'timeline'])->name('tasks.timeline.data');
Route::get('/tasks/timeline', function () {
    return view('tasks.timeline');
})->name('tasks.timeline');

// Routes for creating/editing/updating tasks (accessible to admins and managers)
Route::group(['middleware' => ['role:admin|manager']], function () {
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks/store', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::post('/tasks/update', [TaskController::class, 'update'])->name('tasks.update');
});

// Common routes for viewing/deleting tasks (the destroy method will be protected in the view)
Route::resource('tasks', TaskController::class)->except(['create', 'store', 'edit', 'update']);

// Other resource routes
Route::resource('tasks.comments', TaskCommentController::class);
Route::resource('categories', CategoryController::class);

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
