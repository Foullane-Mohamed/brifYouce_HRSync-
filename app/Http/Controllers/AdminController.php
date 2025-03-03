<?php
// app/Http/Controllers/AdminController.php
namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\LeaveRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function dashboard()
    {
        // قم بتضمين هذه البيانات لتحديث لوحة التحكم
        $totalEmployees = User::count();
        $totalDepartments = Department::count();
        $pendingLeaveRequests = LeaveRequest::where('status', 'pending')->count();
        $recentUsers = User::with('role')->latest()->take(5)->get();
        
        return view('admin.dashboard', compact(
            'totalEmployees', 
            'totalDepartments', 
            'pendingLeaveRequests',
            'recentUsers'
        ));
    }
    
    // User Management
    public function userIndex()
    {
        $users = User::with('role')->paginate(10);
        return view('admin.users.index', compact('users'));
    }
    
    public function userCreate()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }
    
    public function userStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'employee_id' => 'nullable|string|unique:users',
            'phone_number' => 'nullable|string',
            'address' => 'nullable|string',
            'position' => 'nullable|string',
            'department' => 'nullable|string',
            'hire_date' => 'nullable|date',
            'salary' => 'nullable|numeric',
        ]);
        
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'employee_id' => $request->employee_id,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'position' => $request->position,
            'department' => $request->department,
            'hire_date' => $request->hire_date,
            'salary' => $request->salary,
            'is_active' => true,
        ]);
        
        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }
    
    public function userShow(User $user)
    {
        return view('admin.users.show', compact('user'));
    }
    
    public function userEdit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }
    
    public function userUpdate(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role_id' => 'required|exists:roles,id',
            'employee_id' => ['nullable', 'string', Rule::unique('users')->ignore($user->id)],
            'phone_number' => 'nullable|string',
            'address' => 'nullable|string',
            'position' => 'nullable|string',
            'department' => 'nullable|string',
            'hire_date' => 'nullable|date',
            'salary' => 'nullable|numeric',
            'is_active' => 'boolean',
        ]);
        
        $user->update($request->except('password'));
        
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);
            
            $user->password = Hash::make($request->password);
            $user->save();
        }
        
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }
    
    public function userDestroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
    
    // Department Management
    public function departmentIndex()
    {
        $departments = Department::with('manager')->paginate(10);
        return view('admin.departments.index', compact('departments'));
    }
    
    public function departmentCreate()
    {
        $managers = User::whereHas('role', function($query) {
            $query->where('slug', 'employee')->orWhere('slug', 'hr');
        })->get();
        
        // إذا لم يكن هناك مستخدمين، احصل على جميع المستخدمين
        if ($managers->isEmpty()) {
            $managers = User::all();
        }
        
        return view('admin.departments.create', compact('managers'));
    }
    
    public function departmentStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:departments',
            'description' => 'nullable|string',
            'manager_id' => 'nullable|exists:users,id',
        ]);
        
        Department::create($request->all());
        
        return redirect()->route('admin.departments.index')->with('success', 'Department created successfully.');
    }
    
    public function departmentShow(Department $department)
    {
        return view('admin.departments.show', compact('department'));
    }
    
    public function departmentEdit(Department $department)
    {
        $managers = User::whereHas('role', function($query) {
            $query->where('slug', 'employee')->orWhere('slug', 'hr');
        })->get();
        
        // إذا لم يكن هناك مستخدمين، احصل على جميع المستخدمين
        if ($managers->isEmpty()) {
            $managers = User::all();
        }
        
        return view('admin.departments.edit', compact('department', 'managers'));
    }
    
    public function departmentUpdate(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => ['required', 'string', Rule::unique('departments')->ignore($department->id)],
            'description' => 'nullable|string',
            'manager_id' => 'nullable|exists:users,id',
        ]);
        
        $department->update($request->all());
        
        return redirect()->route('admin.departments.index')->with('success', 'Department updated successfully.');
    }
    
    public function departmentDestroy(Department $department)
    {
        $department->delete();
        return redirect()->route('admin.departments.index')->with('success', 'Department deleted successfully.');
    }
    
    // Leave Request Management
    public function leaveRequestIndex(Request $request)
    {
        $query = LeaveRequest::with(['user', 'approver']);
        
        // تصفية حسب الحالة إذا تم تحديدها
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $leaveRequests = $query->latest()->paginate(10);
        
        return view('admin.leave-requests.index', compact('leaveRequests'));
    }
    
    public function leaveRequestShow(LeaveRequest $leaveRequest)
    {
        return view('admin.leave-requests.show', compact('leaveRequest'));
    }
    
    public function leaveRequestUpdate(Request $request, LeaveRequest $leaveRequest)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'admin_comment' => 'nullable|string',
        ]);
        
        $leaveRequest->status = $request->status;
        $leaveRequest->admin_comment = $request->admin_comment;
        
        if (in_array($request->status, ['approved', 'rejected'])) {
            $leaveRequest->approved_by = auth()->id();
        }
        
        $leaveRequest->save();
        
        return redirect()->route('admin.leave-requests.index')->with('success', 'Leave request updated successfully.');
    }
}