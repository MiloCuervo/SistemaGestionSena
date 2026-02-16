<?php

use App\Http\Controllers\ContactsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\ProcessesController;
use App\Http\Controllers\CasesController;
use App\Models\Cases;
use Illuminate\Support\Facades\Auth;



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

        // Gestion de Usuarios
        Route::get('/users', [UserController::class, '__invoke'])->name('users');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');

        // Gestion de Roles
        Route::get('/roles', RolesController::class)->name('roles');

        // Gestion de Procesos
        Route::get('/processes', [ProcessesController::class, '__invoke'])->name('processes');
        Route::post('/processes', [ProcessesController::class, 'store'])->name('processes.store');
        Route::put('/processes/{id}', [ProcessesController::class, 'update'])->name('processes.update');
        Route::delete('/processes/{id}', [ProcessesController::class, 'destroy'])->name('processes.destroy');
        Route::get('/processes/{id}', [ProcessesController::class, 'show'])->name('processes.show');

        // Gestion de Reportes
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

        // Gestion de Casos
        Route::get('/cases', [CasesController::class, '__invoke'])->name('cases');
        Route::post('/cases', [CasesController::class, 'store'])->name('cases.store');
        Route::get('/cases/{id}/edit', [CasesController::class, 'edit'])->name('cases.edit');
        Route::put('/cases/{id}', [CasesController::class, 'update'])->name('cases.update');
        Route::put('/cases/{id}/status', [CasesController::class, 'updateStatus'])->name('cases.update-status');
        Route::get('/cases/{id}/tracking', [CasesController::class, 'tracking'])->name('cases.tracking');
        Route::get('/cases/{id}', [CasesController::class, 'show'])->name('cases.show');

        // Acceso general a tracking desde el sidebar (sin id explicito)
        Route::get('/cases-tracking', function () {
            $latestCaseId = Cases::where('user_id', Auth::id())->latest()->value('id');

            if (!$latestCaseId) {
                return redirect()->route('user.cases');
            }

            return redirect()->route('user.cases.tracking', $latestCaseId);
        })->name('cases-tracking');


        // Gestion de Contactos
        Route::get('/contacts', [ContactsController::class, '__invoke'])->name('contacts');
        Route::post('/contacts', [ContactsController::class, 'store'])->name('contacts.store');
        Route::get('/contacts/{id}', [ContactsController::class, 'show'])->name('contacts.show');

        // Gestion de Reportes
        Route::get('/reports', [UserController::class, 'reports'])->name('reports');

        //Seguimientos de caso
        Route::post('/cases/{id}/follow-ups', [CasesController::class, 'addFollowUp'])->name('cases.follow-ups');

    });

require __DIR__ . '/settings.php';
