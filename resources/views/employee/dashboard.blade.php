
@extends('layouts.app')

@section('title', 'Employee Dashboard')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <h1 class="text-2xl font-semibold mb-6">Welcome, {{ auth()->user()->name }}</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- Pending Leave Requests Card -->
            <div class="bg-blue-50 overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
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
                                        {{ $pendingLeaveRequests }}
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-blue-100 px-4 py-4 sm:px-6">
                    <div class="text-sm">
                        <a href="{{ route('employee.leave-requests.index') }}" class="font-medium text-blue-700 hover:text-blue-900">
                            View all leave requests
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Approved Leave Requests Card -->
            <div class="bg-green-50 overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Approved Leave Requests
                                </dt>
                                <dd>
                                    <div class="text-lg font-semibold text-gray-900">
                                        {{ $approvedLeaveRequests }}
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-green-100 px-4 py-4 sm:px-6">
                    <div class="text-sm">
                        <a href="{{ route('employee.leave-requests.index') }}" class="font-medium text-green-700 hover:text-green-900">
                            View all leave requests
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Latest Performance Review Card -->
            <div class="bg-purple-50 overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Latest Performance Rating
                                </dt>
                                <dd>
                                    <div class="text-lg font-semibold text-gray-900">
                                        @if ($latestPerformanceReview)
                                            {{ $latestPerformanceReview->rating }}/5
                                        @else
                                            N/A
                                        @endif
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-purple-100 px-4 py-4 sm:px-6">
                    <div class="text-sm">
                        <a href="{{ route('employee.performance-reviews.index') }}" class="font-medium text-purple-700 hover:text-purple-900">
                            View all performance reviews
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Attendance Actions -->
            <div class="bg-white border rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-semibold mb-4">Today's Attendance</h2>
                
                <div class="flex space-x-4">
                    <form action="{{ route('employee.attendance.clock-in') }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                            <i class="fas fa-sign-in-alt mr-2"></i> Clock In
                        </button>
                    </form>
                    
                    <form action="{{ route('employee.attendance.clock-out') }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                            <i class="fas fa-sign-out-alt mr-2"></i> Clock Out
                        </button>
                    </form>
                </div>
                
                <div class="mt-4">
                    <a href="{{ route('employee.attendance.index') }}" class="text-blue-600 hover:text-blue-800">
                        View your attendance history
                    </a>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="bg-white border rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-semibold mb-4">Quick Actions</h2>
                
                <div class="space-y-4">
                    <a href="{{ route('employee.leave-requests.create') }}" class="flex items-center p-3 bg-blue-50 hover:bg-blue-100 rounded-lg">
                        <div class="flex-shrink-0 bg-blue-500 rounded-full p-2">
                            <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="font-medium">Request Leave</h3>
                            <p class="text-sm text-gray-500">Submit a new leave request</p>
                        </div>
                    </a>
                    
                    <a href="{{ route('employee.profile') }}" class="flex items-center p-3 bg-purple-50 hover:bg-purple-100 rounded-lg">
                        <div class="flex-shrink-0 bg-purple-500 rounded-full p-2">
                            <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="font-medium">Update Profile</h3>
                            <p class="text-sm text-gray-500">Update your personal information</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection