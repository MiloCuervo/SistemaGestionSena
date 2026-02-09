<?php

use App\Http\Controllers\ContactsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\ProcessesController;
use App\Http\Controllers\UserCasesController;


Route::get('/', function () {
    return view('welcome');
})->name('home');



// ==========================================
// RUTAS DE ADMINISTRADOR 
// ==========================================
Route::middleware(['auth', 'verified', 'role:1'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard Admin
        Route::view('/dashboard', 'admin.dashboard')->name('dashboard');

        // Gestión de Usuarios
        Route::get('/users', [UserController::class, '__invoke'])->name('users');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');

        // Gestión de Roles
        Route::get('/roles', RolesController::class)->name('roles');

        // Gestión de Procesos
        Route::get('/processes', [ProcessesController::class, '__invoke'])->name('processes');
        Route::post('/processes', [ProcessesController::class, 'store'])->name('processes.store');
        Route::put('/processes/{id}', [ProcessesController::class, 'update'])->name('processes.update');
        Route::delete('/processes/{id}', [ProcessesController::class, 'destroy'])->name('processes.destroy');
        Route::get('/processes/{id}', [ProcessesController::class, 'show'])->name('processes.show');

        // Gestión de Reportes
        Route::view('/reports', 'admin.reports')->name('reports');
    });

// ==========================================
// RUTAS DE COMISIONADO / USUARIO 
// ==========================================
Route::middleware(['auth', 'verified', 'role:2'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        // Dashboard Usuario
        Route::view('/dashboard', 'user.dashboard')->name('dashboard');

        // Gestión de Casos
        Route::get('/cases', [UserCasesController::class, '__invoke'])->name('cases');
        Route::post('/cases', [UserCasesController::class, 'store'])->name('cases.store');
        Route::get('/cases/{id}/edit', [UserCasesController::class, 'edit'])->name('cases.edit');
        Route::put('/cases/{id}', [UserCasesController::class, 'update'])->name('cases.update');
        Route::put('/cases/{id}/status', [UserCasesController::class, 'updateStatus'])->name('cases.update-status');
        Route::get('/cases/{id}', [UserCasesController::class, 'show'])->name('cases.show');


        // Gestión de Contactos
        Route::get('/contacts',[ContactsController::class, '__invoke'])->name('contacts');
        Route::post('/contacts', [ContactsController::class, 'store'])->name('contacts.store');
        Route::get('/contacts/{id}', [ContactsController::class, 'show'])->name('contacts.show');

        // Gestión de Reportes
        Route::get('/reports', [UserController::class, 'reports'])->name('reports');

    });

require __DIR__ . '/settings.php';