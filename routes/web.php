<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\CareerDevelopmentController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\OrgChartController;
use App\Http\Controllers\DashboardController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Companies
    Route::resource('companies', CompanyController::class);
    
    // Departments
    Route::resource('departments', DepartmentController::class);
    
    // Employees
    Route::resource('employees', EmployeeController::class);
    
    // Contracts
    Route::resource('contracts', ContractController::class);
    
    // Career Developments
    Route::resource('career-developments', CareerDevelopmentController::class);
    
    // Trainings
    Route::resource('trainings', TrainingController::class);
    Route::post('/trainings/{training}/employees', [TrainingController::class, 'assignEmployees'])->name('trainings.employees.assign');
    Route::patch('/trainings/{training}/employees/{employee}', [TrainingController::class, 'updateStatus'])->name('trainings.employees.status');
    
    // Organization Chart
    Route::get('/org-chart', [OrgChartController::class, 'index'])->name('org-chart.index');
});