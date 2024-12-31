<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\TaskController;
use \App\Http\Controllers\TimeController;
use \App\Http\Controllers\HomeController;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\GroupsTaskController;
use \App\Http\Controllers\GroupController;
use \App\Http\Controllers\UsersGroupController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',function (){return view('home');})->name('home');

Route::get('/dashboard', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('tasks', TaskController::class);
    Route::resource('times', TimeController::class);
    Route::resource('users', UserController::class);
    Route::resource('groups', GroupController::class);

    Route::get('groupsTask/{task}', [GroupsTaskController::class, 'showForm'])->name('showGroupTaskForm');
    Route::post('addgroupsTask', [GroupsTaskController::class, 'add'])->name('addGroupTask');
    Route::post('removegroupsTask', [GroupsTaskController::class, 'remove'])->name('removeGroupTask');

    Route::get('usersGroup/{group}', [UsersGroupController::class, 'showForm'])->name('showUserGroupForm');
    Route::post('addusersGroup', [UsersGroupController::class, 'add'])->name('addUserGroup');
    Route::post('removeusersGroup', [UsersGroupController::class, 'remove'])->name('removeUserGroup');
});

require __DIR__.'/auth.php';
