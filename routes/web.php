<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskCommentController;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\UserController;


Route::get('/', function () {
    return view('welcome');
});

// Admin routes (only accessible by admin)
Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/admin/users/{user}/change-role', [AdminController::class, 'changeRole'])->name('admin.changeRole');
});


// Manager routes (only accessible by manager)
Route::group(['middleware' => ['role:manager']], function () {
    Route::get('/manager/dashboard', [ManagerController::class, 'dashboard'])->name('manager.dashboard');
    // Manager tasks could be handled with TaskController or their own methods.
    Route::get('/manager/tasks', [ManagerController::class, 'tasks'])->name('manager.tasks');
    // ... add more manager-specific routes as needed
});


// User routes (for regular users)
Route::group(['middleware' => ['role:user']], function () {
    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    // Users can see tasks assigned to them
    Route::get('/user/tasks', [UserController::class, 'tasks'])->name('user.tasks');
});

// Common routes (e.g., tasks that are accessible to all roles, if needed)
Route::resource('tasks', TaskController::class);

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




//Extra features
Route::get('/tasks/search', [TaskController::class, 'search'])->name('tasks.search');
Route::get('/tasks/timeline/data', [TaskController::class, 'timeline'])->name('tasks.timeline.data');
Route::get('/tasks/timeline', function () {
    return view('tasks.timeline');
})->name('tasks.timeline');


Route::resource('tasks', TaskController::class);
Route::resource('tasks.comments', TaskCommentController::class);

require __DIR__ . '/auth.php';
