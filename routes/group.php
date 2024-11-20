<?php

use App\Http\Controllers\GroupController;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Route;


// Room todos
Route::get('/group', [GroupController::class, 'Index'])->name('group')->middleware([AuthMiddleware::class]);


Route::get('/group/{id}/tasks', [GroupController::class, 'Tasks'])->name('group.list');
Route::get('/group/{id}/settings', [GroupController::class, 'Settings'])->name('group.settings');

Route::post('/group', [GroupController::class, 'Store'])->name('group.post.store');
Route::post('/group/{id}/edit', [GroupController::class, 'Edit'])->name('group.post.edit');
Route::get('/group/{id}/delete', [GroupController::class, 'Delete'])->name('group.post.delete');

Route::get('/group/{id}/post/addUser', [GroupController::class, 'AddUser'])->name('group.user.add');
Route::post('/group/{id}/post/removeUser', [GroupController::class, 'RemoveUser'])->name('group.user.remove');
Route::get('/group/{id}/post/assign', [GroupController::class, 'Assign'])->name('group.user.assign');
Route::get('/group/invite/{invite}', [GroupController::class, 'Invite'])->name('group.invite');
