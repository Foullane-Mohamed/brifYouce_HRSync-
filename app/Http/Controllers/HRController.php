<?php
namespace App\Http\Controllers;

use App\Models\AttendanceRecord;
use App\Models\LeaveRequest;
use App\Models\PerformanceReview;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HRController extends Controller
{
    public function dashboard()
    {
        $totalEmployees = User::count();
        $pendingLeaveRequests = LeaveRequest::where('status', 'pending')->count();
        
        return view('hr.dashboard', compact('totalEmployees', 'pendingLeaveRequests'));
    }
    
    // Employee Management
    public function employeeIndex()
    {
        $employees = User::whereHas('role', function($query) {
            $query->where('slug', 'employee');
        })->paginate(10);
        
        return view('hr.employees.index', compact('employees'));
    }
    
    public function employeeShow(User $employee)
    {
        return view('hr.employees.show', compact('employee'));
    }
    
    // Leave Request Management
    public function leaveRequestIndex()
    {
        $leaveRequests = LeaveRequest::with('user')->paginate(10);
        return view('hr.leave-requests.index', compact('leaveRequests'));
    }
    
    public function leaveRequestShow(LeaveRequest $leaveRequest)
    {
        return view('hr.leave-requests.show', compact('leaveRequest'));
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
        
        return redirect()->route('hr.leave-requests.index')->with('success', 'Leave request updated successfully.');
    }
    
    // Attendance Management
    public function attendanceIndex()
    {
        $attendanceRecords = AttendanceRecord::with('user')->paginate(10);
        return view('hr.attendance.index', compact('attendanceRecords'));
    }
    
    public function attendanceCreate()
    {
        $employees = User::whereHas('role', function($query) {
            $query->where('slug', 'employee');
        })->get();
        
        return view('hr.attendance.create', compact('employees'));
    }
    
    public function attendanceStore(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'clock_in' => 'nullable|date_format:H:i',
            'clock_out' => 'nullable|date_format:H:i|after:clock_in',
            'break_start' => 'nullable|date_format:H:i|after:clock_in',
            'break_end' => 'nullable|date_format:H:i|after:break_start',
            'status' => 'required|string',
            'remarks' => 'nullable|string',
        ]);
        
        AttendanceRecord::create($request->all());
        
        return redirect()->route('hr.attendance.index')->with('success', 'Attendance record created successfully.');
    }
    
    public function attendanceEdit(AttendanceRecord $attendanceRecord)
    {
        $employees = User::whereHas('role', function($query) {
            $query->where('slug', 'employee');
        })->get();
        
        return view('hr.attendance.edit', compact('attendanceRecord', 'employees'));
    }
    
    public function attendanceUpdate(Request $request, AttendanceRecord $attendanceRecord)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'clock_in' => 'nullable|date_format:H:i',
            'clock_out' => 'nullable|date_format:H:i|after:clock_in',
            'break_start' => 'nullable|date_format:H:i|after:clock_in',
            'break_end' => 'nullable|date_format:H:i|after:break_start',
            'status' => 'required|string',
            'remarks' => 'nullable|string',
        ]);
        
        $attendanceRecord->update($request->all());
        
        return redirect()->route('hr.attendance.index')->with('success', 'Attendance record updated successfully.');
    }
    
    // Performance Review Management
    public function performanceReviewIndex()
    {
        $performanceReviews = PerformanceReview::with(['user', 'reviewer'])->paginate(10);
        return view('hr.performance-reviews.index', compact('performanceReviews'));
    }
    
    public function performanceReviewCreate()
    {
        $employees = User::whereHas('role', function($query) {
            $query->where('slug', 'employee');
        })->get();
        
        return view('hr.performance-reviews.create', compact('employees'));
    }
    
    public function performanceReviewStore(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'review_date' => 'required|date',
            'rating' => 'required|integer|min:1|max:5',
            'achievements' => 'nullable|string',
            'areas_for_improvement' => 'nullable|string',
            'goals' => 'nullable|string',
            'comments' => 'nullable|string',
        ]);
        
        PerformanceReview::create([
            'user_id' => $request->user_id,
            'reviewer_id' => Auth::id(),
            'review_date' => $request->review_date,
            'rating' => $request->rating,
            'achievements' => $request->achievements,
            'areas_for_improvement' => $request->areas_for_improvement,
            'goals' => $request->goals,
            'comments' => $request->comments,
        ]);
        
        return redirect()->route('hr.performance-reviews.index')->with('success', 'Performance review created successfully.');
    }
    
    public function performanceReviewShow(PerformanceReview $performanceReview)
    {
        return view('hr.performance-reviews.show', compact('performanceReview'));
    }
    
    public function performanceReviewEdit(PerformanceReview $performanceReview)
    {
        $employees = User::whereHas('role', function($query) {
            $query->where('slug', 'employee');
        })->get();
        
        return view('hr.performance-reviews.edit', compact('performanceReview', 'employees'));
    }
    
    public function performanceReviewUpdate(Request $request, PerformanceReview $performanceReview)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'review_date' => 'required|date',
            'rating' => 'required|integer|min:1|max:5',
            'achievements' => 'nullable|string',
            'areas_for_improvement' => 'nullable|string',
            'goals' => 'nullable|string',
            'comments' => 'nullable|string',
        ]);
        
        $performanceReview->update([
            'user_id' => $request->user_id,
            'review_date' => $request->review_date,
            'rating' => $request->rating,
            'achievements' => $request->achievements,
            'areas_for_improvement' => $request->areas_for_improvement,
            'goals' => $request->goals,
            'comments' => $request->comments,
        ]);
        
        return redirect()->route('hr.performance-reviews.index')->with('success', 'Performance review updated successfully.');
    }
}