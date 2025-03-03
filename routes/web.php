<?php


use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HRController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/


Route::get('/', function () {
    return view('welcome');
});


require __DIR__.'/auth.php';


Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif (auth()->user()->isHR()) {
            return redirect()->route('hr.dashboard');
        } elseif (auth()->user()->isEmployee()) {
            return redirect()->route('employee.dashboard');
        } else {
      
            return view('dashboard');
        }
    })->name('dashboard');

  
    Route::middleware(['is_admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
    
        Route::get('/users', [AdminController::class, 'userIndex'])->name('users.index');
        Route::get('/users/create', [AdminController::class, 'userCreate'])->name('users.create');
        Route::post('/users', [AdminController::class, 'userStore'])->name('users.store');
        Route::get('/users/{user}', [AdminController::class, 'userShow'])->name('users.show');
        Route::get('/users/{user}/edit', [AdminController::class, 'userEdit'])->name('users.edit');
        Route::put('/users/{user}', [AdminController::class, 'userUpdate'])->name('users.update');
        Route::delete('/users/{user}', [AdminController::class, 'userDestroy'])->name('users.destroy');
        
    
        Route::get('/departments', [AdminController::class, 'departmentIndex'])->name('departments.index');
        Route::get('/departments/create', [AdminController::class, 'departmentCreate'])->name('departments.create');
        Route::post('/departments', [AdminController::class, 'departmentStore'])->name('departments.store');
        Route::get('/departments/{department}', [AdminController::class, 'departmentShow'])->name('departments.show');
        Route::get('/departments/{department}/edit', [AdminController::class, 'departmentEdit'])->name('departments.edit');
        Route::put('/departments/{department}', [AdminController::class, 'departmentUpdate'])->name('departments.update');
        Route::delete('/departments/{department}', [AdminController::class, 'departmentDestroy'])->name('departments.destroy');
        
      
        Route::get('/leave-requests', [AdminController::class, 'leaveRequestIndex'])->name('leave-requests.index');
        Route::get('/leave-requests/{leaveRequest}', [AdminController::class, 'leaveRequestShow'])->name('leave-requests.show');
        Route::put('/leave-requests/{leaveRequest}', [AdminController::class, 'leaveRequestUpdate'])->name('leave-requests.update');
    });
    

    Route::middleware(['is_hr'])->prefix('hr')->name('hr.')->group(function () {
        Route::get('/dashboard', [HRController::class, 'dashboard'])->name('dashboard');
        
    
        Route::get('/employees', [HRController::class, 'employeeIndex'])->name('employees.index');
        Route::get('/employees/{employee}', [HRController::class, 'employeeShow'])->name('employees.show');
        
        Route::get('/leave-requests', [HRController::class, 'leaveRequestIndex'])->name('leave-requests.index');
        Route::get('/leave-requests/{leaveRequest}', [HRController::class, 'leaveRequestShow'])->name('leave-requests.show');
        Route::put('/leave-requests/{leaveRequest}', [HRController::class, 'leaveRequestUpdate'])->name('leave-requests.update');
        
        Route::get('/attendance', [HRController::class, 'attendanceIndex'])->name('attendance.index');
        Route::get('/attendance/create', [HRController::class, 'attendanceCreate'])->name('attendance.create');
        Route::post('/attendance', [HRController::class, 'attendanceStore'])->name('attendance.store');
        Route::get('/attendance/{attendanceRecord}/edit', [HRController::class, 'attendanceEdit'])->name('attendance.edit');
        Route::put('/attendance/{attendanceRecord}', [HRController::class, 'attendanceUpdate'])->name('attendance.update');
        
        Route::get('/performance-reviews', [HRController::class, 'performanceReviewIndex'])->name('performance-reviews.index');
        Route::get('/performance-reviews/create', [HRController::class, 'performanceReviewCreate'])->name('performance-reviews.create');
        Route::post('/performance-reviews', [HRController::class, 'performanceReviewStore'])->name('performance-reviews.store');
        Route::get('/performance-reviews/{performanceReview}', [HRController::class, 'performanceReviewShow'])->name('performance-reviews.show');
        Route::get('/performance-reviews/{performanceReview}/edit', [HRController::class, 'performanceReviewEdit'])->name('performance-reviews.edit');
        Route::put('/performance-reviews/{performanceReview}', [HRController::class, 'performanceReviewUpdate'])->name('performance-reviews.update');
    });
    
    Route::middleware(['is_employee'])->prefix('employee')->name('employee.')->group(function () {
        Route::get('/dashboard', [EmployeeController::class, 'dashboard'])->name('dashboard');
        
        Route::get('/profile', [EmployeeController::class, 'profile'])->name('profile');
        Route::put('/profile', [EmployeeController::class, 'updateProfile'])->name('profile.update');
        
        Route::get('/leave-requests', [EmployeeController::class, 'leaveRequestIndex'])->name('leave-requests.index');
        Route::get('/leave-requests/create', [EmployeeController::class, 'leaveRequestCreate'])->name('leave-requests.create');
        Route::post('/leave-requests', [EmployeeController::class, 'leaveRequestStore'])->name('leave-requests.store');
        Route::get('/leave-requests/{leaveRequest}', [EmployeeController::class, 'leaveRequestShow'])->name('leave-requests.show');
        
        Route::get('/attendance', [EmployeeController::class, 'attendanceIndex'])->name('attendance.index');
        Route::post('/attendance/clock-in', [EmployeeController::class, 'clockIn'])->name('attendance.clock-in');
        Route::post('/attendance/clock-out', [EmployeeController::class, 'clockOut'])->name('attendance.clock-out');
        
        Route::get('/performance-reviews', [EmployeeController::class, 'performanceReviewIndex'])->name('performance-reviews.index');
        Route::get('/performance-reviews/{performanceReview}', [EmployeeController::class, 'performanceReviewShow'])->name('performance-reviews.show');
    });
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});