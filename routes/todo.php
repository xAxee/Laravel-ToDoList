<?php

use App\Http\Controllers\TaskController;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Route;


// Single todo
Route::get('/todo/list', [TaskController::class, 'Index'])->name('todo')->middleware([AuthMiddleware::class]);

Route::post('/todo/post/store', [TaskController::class, 'Store'])->name('todo.post.store');
Route::post('/todo/post/edit/{id}', [TaskController::class, 'Edit'])->name('todo.post.edit');
Route::get('/todo/post/delete/{id}', [TaskController::class, 'Delete'])->name('todo.post.delete');

Route::get('/todo/post/up/{id}', [TaskController::class, 'Up'])->name('todo.post.up');
Route::get('/todo/post/down/{id}', [TaskController::class, 'Down'])->name('todo.post.down');
