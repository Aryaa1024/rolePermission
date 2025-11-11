<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RolePermissionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('login', [AuthController::class, 'showLogin'])->name('loginForm');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'checkPermission']], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('role-permission', [RolePermissionController::class, 'index'])->name('rolepermissions.index');
    Route::post('role-permission/store', [RolePermissionController::class, 'store'])->name('rolepermissions.store');
    Route::get('role-permission/{id}/edit', [RolePermissionController::class, 'edit'])->name('rolepermissions.edit');
    Route::delete('role-permission/{id}/delete', [RolePermissionController::class, 'destroy'])->name('rolepermissions.delete');
});
