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
