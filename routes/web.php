<?php
use App\Http\Controllers\Admin\DepartementController;
use App\Http\Controllers\Admin\EmployeController;
use App\Http\Controllers\Admin\EntrepriseController;
use App\Http\Controllers\Admin\HierarchieController;


Route::prefix('admin')->name('admin.')->group(function () {

    Route::resource('departements', DepartementController::class);
    Route::resource('employes', EmployeController::class);
    Route::resource('entreprises', EntrepriseController::class);
    Route::resource('hierarchies', HierarchieController::class);
});




Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    // Company routes
    Route::resource('companies', CompanyController::class);
    
    // Department routes
    Route::resource('departments', DepartmentController::class);
    
    // Employee routes
    Route::resource('employees', EmployeeController::class);
    Route::get('org-chart', [EmployeeController::class, 'orgChart'])->name('employees.org-chart');
    
    // Career Events routes
    Route::resource('career-events', CareerEventController::class);
    Route::get('employees/{employee}/career-events/create', [CareerEventController::class, 'create'])
        ->name('employees.career-events.create');
});

// require __DIR__.'/auth.php';