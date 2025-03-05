{{-- resources/views/hr/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'HR Dashboard')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <h1 class="text-2xl font-semibold mb-6">HR Dashboard</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- Total Employees Card -->
            <div class="bg-blue-50 overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Total Employees
                                </dt>
                                <dd>
                                    <div class="text-lg font-semibold text-gray-900">
                                        {{ \App\Models\User::whereHas('role', function($query) {
                                            $query->where('slug', 'employee');
                                        })->count() }}
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-blue-100 px-4 py-4 sm:px-6">
                    <div class="text-sm">
                        <a href="{{ route('hr.employees.index') }}" class="font-medium text-blue-700 hover:text-blue-900">
                            View all employees
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Pending Leave Requests Card -->
            <div class="bg-yellow-50 overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Pending Leave Requests
                                </dt>
                                <dd>
                                    <div class="text-lg font-semibold text-gray-900">
                                        {{ \App\Models\LeaveRequest::where('status', 'pending')->count() }}
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-yellow-100 px-4 py-4 sm:px-6">
                    <div class="text-sm">
                        <a href="{{ route('hr.leave-requests.index') }}" class="font-medium text-yellow-700 hover:text-yellow-900">
                            View all leave requests
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Today's Attendance Card -->
            <div class="bg-green-50 overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Today's Attendance
                                </dt>
                                <dd>
                                    <div class="text-lg font-semibold text-gray-900">
                                        {{ \App\Models\AttendanceRecord::whereDate('date', today())->count() }}
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-green-100 px-4 py-4 sm:px-6">
                    <div class="text-sm">
                        <a href="{{ route('hr.attendance.index') }}" class="font-medium text-green-700 hover:text-green-900">
                            View attendance records
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-8">
            <h2 class="text-xl font-semibold mb-4">Quick Actions</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('hr.attendance.create') }}" class="flex items-center p-4 bg-white border rounded-lg shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex-shrink-0 bg-blue-500 rounded-full p-2">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold">Record Attendance</h3>
                        <p class="text-gray-500 text-sm">Add attendance record</p>
                    </div>
                </a>
                
                <a href="{{ route('hr.performance-reviews.create') }}" class="flex items-center p-4 bg-white border rounded-lg shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex-shrink-0 bg-green-500 rounded-full p-2">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold">Add Review</h3>
                        <p class="text-gray-500 text-sm">Create performance review</p>
                    </div>
                </a>
                
                <a href="{{ route('hr.leave-requests.index') }}" class="flex items-center p-4 bg-white border rounded-lg shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex-shrink-0 bg-yellow-500 rounded-full p-2">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold">Leave Requests</h3>
                        <p class="text-gray-500 text-sm">Manage leave requests</p>
                    </div>
                </a>
                
                <a href="{{ route('profile.edit') }}" class="flex items-center p-4 bg-white border rounded-lg shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex-shrink-0 bg-purple-500 rounded-full p-2">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold">Your Profile</h3>
                        <p class="text-gray-500 text-sm">View and edit profile</p>
                    </div>
                </a>
            </div>
        </div>
        
        <!-- Recent Leave Requests -->
        <div class="mt-10">
            <h2 class="text-xl font-semibold mb-4">Recent Leave Requests</h2>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dates</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach(\App\Models\LeaveRequest::with('user')->latest()->take(5)->get() as $leaveRequest)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $leaveRequest->user->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $leaveRequest->type }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $leaveRequest->start_date->format('M d') }} - {{ $leaveRequest->end_date->format('M d, Y') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($leaveRequest->status === 'pending')
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Pending
                                        </span>
                                    @elseif($leaveRequest->status === 'approved')
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Approved
                                        </span>
                                    @else
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Rejected
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('hr.leave-requests.show', $leaveRequest) }}" class="text-blue-600 hover:text-blue-900">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection