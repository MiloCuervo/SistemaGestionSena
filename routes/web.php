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
// ADMINISTRATOR ROUTES 
// ==========================================
Route::middleware(['auth', 'verified', 'role:1'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Admin Dashboard
        Route::view('/dashboard', 'admin.dashboard')->name('dashboard');

        // User Management
        Route::get('/users', [UserController::class, '__invoke'])->name('users');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');

        // Roles Management
        Route::get('/roles', RolesController::class)->name('roles');

        // processes Management
        Route::get('/processes', [ProcessesController::class, '__invoke'])->name('processes');
        Route::post('/processes', [ProcessesController::class, 'store'])->name('processes.store');
        Route::put('/processes/{id}', [ProcessesController::class, 'update'])->name('processes.update');
        Route::delete('/processes/{id}', [ProcessesController::class, 'destroy'])->name('processes.destroy');
        Route::get('/processes/{id}', [ProcessesController::class, 'show'])->name('processes.show');

        // reports Management
        Route::view('/reports', 'admin.reports')->name('reports');
    });

// ==========================================
// User / Commissioner ROUTES
// ==========================================
Route::middleware(['auth', 'verified', 'role:2'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        // User Dashboard
        Route::view('/dashboard', 'user.dashboard')->name('dashboard');

        // Cases Management
        Route::get('/cases', [CasesController::class, '__invoke'])->name('cases');
        Route::post('/cases', [CasesController::class, 'store'])->name('cases.store');
        Route::get('/cases/{id}/edit', [CasesController::class, 'edit'])->name('cases.edit');
        Route::put('/cases/{id}', [CasesController::class, 'update'])->name('cases.update');
        Route::put('/cases/{id}/status', [CasesController::class, 'updateStatus'])->name('cases.update-status');
        Route::get('/cases/{id}/tracking', [CasesController::class, 'tracking'])->name('cases.tracking');
        Route::get('/cases/{id}', [CasesController::class, 'show'])->name('cases.show');

        // General Accsess To Tracking From Sidebar (Without Explicit Id)
        Route::get('/cases-tracking', function () {
            $latestCaseId = Cases::where('user_id', Auth::id())->latest()->value('id');

            if (!$latestCaseId) {
                return redirect()->route('user.cases');
            }

            return redirect()->route('user.cases.tracking', $latestCaseId);
        })->name('cases-tracking');


        // Contacts Management
        Route::get('/contacts', [ContactsController::class, '__invoke'])->name('contacts');
        Route::post('/contacts', [ContactsController::class, 'store'])->name('contacts.store');
        Route::get('/contacts/{id}', [ContactsController::class, 'show'])->name('contacts.show');

        // Reports Management
        Route::get('/reports', [UserController::class, 'reports'])->name('reports');

        // Cases Follow-Ups
        Route::post('/cases/{id}/follow-ups', [CasesController::class, 'addFollowUp'])->name('cases.follow-ups');

    });

require __DIR__ . '/settings.php';