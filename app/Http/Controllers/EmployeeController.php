<?php
namespace App\Http\Controllers;

use App\Models\AttendanceRecord;
use App\Models\LeaveRequest;
use App\Models\PerformanceReview;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $pendingLeaveRequests = LeaveRequest::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();
        $approvedLeaveRequests = LeaveRequest::where('user_id', $user->id)
            ->where('status', 'approved')
            ->count();
        $latestPerformanceReview = PerformanceReview::where('user_id', $user->id)
            ->latest()
            ->first();
        
        return view('employee.dashboard', compact('pendingLeaveRequests', 'approvedLeaveRequests', 'latestPerformanceReview'));
    }
    
    // Profile Management
    public function profile()
    {
        $user = Auth::user();
        return view('employee.profile', compact('user'));
    }
    
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'nullable|string',
            'address' => 'nullable|string',
        ]);
        
        $user->name = $request->name;
        $user->phone_number = $request->phone_number;
        $user->address = $request->address;
        $user->save();
        
        return redirect()->route('employee.profile')->with('success', 'Profile updated successfully.');
    }
    
    // Leave Request Management
    public function leaveRequestIndex()
    {
        $leaveRequests = LeaveRequest::where('user_id', Auth::id())->paginate(10);
        return view('employee.leave-requests.index', compact('leaveRequests'));
    }
    
    public function leaveRequestCreate()
    {
        return view('employee.leave-requests.create');
    }
    
    public function leaveRequestStore(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'type' => 'required|string',
            'reason' => 'nullable|string',
        ]);
        
        LeaveRequest::create([
            'user_id' => Auth::id(),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'type' => $request->type,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);
        
        return redirect()->route('employee.leave-requests.index')->with('success', 'Leave request submitted successfully.');
    }
    
    public function leaveRequestShow(LeaveRequest $leaveRequest)
    {
        // Ensure the leave request belongs to the authenticated user
        if ($leaveRequest->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('employee.leave-requests.show', compact('leaveRequest'));
    }
    
    // Attendance Management
    public function attendanceIndex()
    {
        $attendanceRecords = AttendanceRecord::where('user_id', Auth::id())->paginate(10);
        return view('employee.attendance.index', compact('attendanceRecords'));
    }
    
    public function clockIn()
    {
        $today = now()->toDateString();
        $user = Auth::user();
        
        // Check if already clocked in today
        $existingRecord = AttendanceRecord::where('user_id', $user->id)
            ->where('date', $today)
            ->first();
        
        if ($existingRecord) {
            if ($existingRecord->clock_in) {
                return redirect()->route('employee.dashboard')->with('error', 'You have already clocked in today.');
            }
            
            $existingRecord->clock_in = now()->toTimeString();
            $existingRecord->save();
        } else {
            AttendanceRecord::create([
                'user_id' => $user->id,
                'date' => $today,
                'clock_in' => now()->toTimeString(),
                'status' => 'present',
            ]);
        }
        
        return redirect()->route('employee.dashboard')->with('success', 'Clocked in successfully.');
    }
    
    public function clockOut()
    {
        $today = now()->toDateString();
        $user = Auth::user();
        
        $record = AttendanceRecord::where('user_id', $user->id)
            ->where('date', $today)
            ->first();
        
        if (!$record) {
            return redirect()->route('employee.dashboard')->with('error', 'No clock-in record found for today.');
        }
        
        if (!$record->clock_in) {
            return redirect()->route('employee.dashboard')->with('error', 'You need to clock in first.');
        }
        
        if ($record->clock_out) {
            return redirect()->route('employee.dashboard')->with('error', 'You have already clocked out today.');
        }
        
        $record->clock_out = now()->toTimeString();
        $record->save();
        
        return redirect()->route('employee.dashboard')->with('success', 'Clocked out successfully.');
    }
    
    // Performance Review
    public function performanceReviewIndex()
    {
        $performanceReviews = PerformanceReview::where('user_id', Auth::id())->paginate(10);
        return view('employee.performance-reviews.index', compact('performanceReviews'));
    }
    
    public function performanceReviewShow(PerformanceReview $performanceReview)
    {
        // Ensure the performance review belongs to the authenticated user
        if ($performanceReview->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('employee.performance-reviews.show', compact('performanceReview'));
    }
}