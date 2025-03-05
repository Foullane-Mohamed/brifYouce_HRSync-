{{-- resources/views/employee/profile.blade.php --}}
@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <h1 class="text-2xl font-semibold mb-6">My Profile</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Personal Information -->
            <div class="md:col-span-2">
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6 bg-gray-50">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Personal Information</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Your personal details and contact information.</p>
                    </div>
                    <div class="border-t border-gray-200">
                        <form action="{{ route('employee.profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="px-4 py-5 sm:p-6">
                                <div class="grid grid-cols-6 gap-6">
                                    <!-- Name -->
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        @error('name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Email (Read-only) -->
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                                        <input type="text" name="email" id="email" value="{{ $user->email }}" disabled class="mt-1 bg-gray-50 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <!-- Phone Number -->
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                        <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number', $user->phone_number) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        @error('phone_number')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Address -->
                                    <div class="col-span-6">
                                        <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                                        <input type="text" name="address" id="address" value="{{ old('address', $user->address) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        @error('address')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Password Update Form -->
                <div class="bg-white shadow overflow-hidden sm:rounded-lg mt-6">
                    <div class="px-4 py-5 sm:px-6 bg-gray-50">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Update Password</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Change your account password.</p>
                    </div>
                    <div class="border-t border-gray-200">
                        <form action="{{ route('password.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="px-4 py-5 sm:p-6">
                                <div class="grid grid-cols-6 gap-6">
                                    <!-- Current Password -->
                                    <div class="col-span-6 sm:col-span-4">
                                        <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                                        <input type="password" name="current_password" id="current_password" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        @error('current_password')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- New Password -->
                                    <div class="col-span-6 sm:col-span-4">
                                        <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                                        <input type="password" name="password" id="password" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        @error('password')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Confirm Password -->
                                    <div class="col-span-6 sm:col-span-4">
                                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Change Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Employment Information (Read-Only) -->
            <div>
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6 bg-gray-50">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Employment Information</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Employment details and status.</p>
                    </div>
                    <div class="border-t border-gray-200 px-4 py-5">
                        <dl class="grid grid-cols-1 gap-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Employee ID</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $user->employee_id ?: 'Not assigned' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Department</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $user->department ?: 'Not assigned' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Position</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $user->position ?: 'Not assigned' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Hire Date</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $user->hire_date ? $user->hire_date->format('F d, Y') : 'Not provided' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    @if($user->is_active)
                                        <span class="px-2 py-1 text-xs font-semibold leading-tight text-green-700 bg-green-100 rounded-full">
                                            Active
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold leading-tight text-red-700 bg-red-100 rounded-full">
                                            Inactive
                                        </span>
                                    @endif
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
                
                <!-- Stats Summary -->
                <div class="bg-white shadow overflow-hidden sm:rounded-lg mt-6">
                    <div class="px-4 py-5 sm:px-6 bg-gray-50">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Stats Summary</h3>
                    </div>
                    <div class="border-t border-gray-200 px-4 py-5">
                        <dl class="grid grid-cols-1 gap-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Total Leave Days (This Year)</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    @php
                                        $totalLeaveDays = $user->leaveRequests()
                                            ->where('status', 'approved')
                                            ->whereYear('start_date', date('Y'))
                                            ->get()
                                            ->sum(function($request) {
                                                return $request->start_date->diffInDays($request->end_date) + 1;
                                            });
                                    @endphp
                                    {{ $totalLeaveDays }} days
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Attendance Rate (This Month)</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    @php
                                        $workingDays = now()->startOfMonth()->diffInWeekdays(now());
                                        $presentDays = $user->attendanceRecords()
                                            ->whereMonth('date', now()->month)
                                            ->whereYear('date', now()->year)
                                            ->where('status', 'present')
                                            ->count();
                                        
                                        $attendanceRate = $workingDays > 0 ? round(($presentDays / $workingDays) * 100) : 0;
                                    @endphp
                                    {{ $attendanceRate }}%
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Latest Performance Rating</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    @php
                                        $latestReview = $user->performanceReviews()
                                            ->orderBy('review_date', 'desc')
                                            ->first();
                                    @endphp
                                    
                                    @if($latestReview)
                                        <div class="flex items-center">
                                            <span class="mr-2">{{ $latestReview->rating }}/5</span>
                                            <div class="flex">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $latestReview->rating)
                                                        <svg class="h-4 w-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                        </svg>
                                                    @else
                                                        <svg class="h-4 w-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                        </svg>
                                                    @endif
                                                @endfor
                                            </div>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">Reviewed on {{ $latestReview->review_date->format('M d, Y') }}</p>
                                    @else
                                        Not rated yet
                                    @endif
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection