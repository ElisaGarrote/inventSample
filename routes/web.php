<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;


// Welcome page
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Login and Logout
Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.showLogin');
Route::post('/admin/login', [AdminController::class, 'processLogin'])->name('admin.login');

// Admin logout route (this is where the `logout` route name should be)
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

// General logout route (if needed for general users)
Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

// Dashboard Routes
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/book-inventory', [BookController::class, 'index'])->name('admin.book_inventory');
    Route::get('/user-management', [UserController::class, 'index'])->name('admin.user_management');
    Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports');
});

// Book Inventory Routes
Route::prefix('books')->group(function () {
    Route::post('/store', [BookController::class, 'store']);
    Route::get('/list', [BookController::class, 'list'])->name('books.list');
    Route::get('/{id}/edit', [BookController::class, 'edit'])->name('books.edit');
    Route::put('/{id}', [BookController::class, 'update'])->name('books.update');
    Route::get('/list', [BookController::class, 'list'])->name('books.list'); // Replaced closure
    Route::get('/archive/{id}', [BookController::class, 'archiveBook'])->name('books.archive');
});

// User Management Routes
Route::prefix('users')->group(function () {
    Route::post('/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/{id}', [UserController::class, 'update'])->name('users.update');
    // Adjust this route for soft deleting a user
    Route::delete('/{id}/delete', [UserController::class, 'destroy'])->name('users.delete'); // Use DELETE for soft delete
});
