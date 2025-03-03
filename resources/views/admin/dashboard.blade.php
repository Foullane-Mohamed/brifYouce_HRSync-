@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <h1 class="text-2xl font-semibold mb-6">Admin Dashboard</h1>
        
        {{-- Debug info - يمكن إزالة هذا القسم بعد حل المشكلة --}}
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4">
            <h3 class="font-bold">Debug Info:</h3>
            <p>Current user role: {{ auth()->user()->role ? auth()->user()->role->name : 'No role assigned' }}</p>
            <p>Is Admin? {{ auth()->user()->isAdmin() ? 'Yes' : 'No' }}</p>
            <p>Total Users: {{ \App\Models\User::count() }}</p>
            <p>Total Departments: {{ \App\Models\Department::count() }}</p>
            <p>Total Leave Requests: {{ \App\Models\LeaveRequest::count() }}</p>
        </div>
        
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
                                        {{ \App\Models\User::count() }}
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-blue-100 px-4 py-4 sm:px-6">
                    <div class="text-sm">
                        <a href="{{ route('admin.users.index') }}" class="font-medium text-blue-700 hover:text-blue-900">
                            View all employees
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Total Departments Card -->
            <div class="bg-green-50 overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Total Departments
                                </dt>
                                <dd>
                                    <div class="text-lg font-semibold text-gray-900">
                                        {{ \App\Models\Department::count() }}
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-green-100 px-4 py-4 sm:px-6">
                    <div class="text-sm">
                        <a href="{{ route('admin.departments.index') }}" class="font-medium text-green-700 hover:text-green-900">
                            View all departments
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
                        <a href="{{ route('admin.leave-requests.index') }}" class="font-medium text-yellow-700 hover:text-yellow-900">
                            View all leave requests
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-8">
            <h2 class="text-xl font-semibold mb-4">Quick Actions</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('admin.users.create') }}" class="flex items-center p-4 bg-white border rounded-lg shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex-shrink-0 bg-blue-500 rounded-full p-2">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold">Add New User</h3>
                        <p class="text-gray-500 text-sm">Create user account</p>
                    </div>
                </a>
                
                <a href="{{ route('admin.departments.create') }}" class="flex items-center p-4 bg-white border rounded-lg shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex-shrink-0 bg-green-500 rounded-full p-2">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold">Add Department</h3>
                        <p class="text-gray-500 text-sm">Create new department</p>
                    </div>
                </a>
                
                <a href="{{ route('admin.leave-requests.index') }}" class="flex items-center p-4 bg-white border rounded-lg shadow-sm hover:shadow-md transition-shadow">
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
        
        {{-- Most Recent Users Section --}}
        <div class="mt-10">
            <h2 class="text-xl font-semibold mb-4">Most Recent Users</h2>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach(\App\Models\User::with('role')->latest()->take(5)->get() as $user)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $user->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        {{ $user->role ? $user->role->name : 'No Role' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $user->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.users.show', $user) }}" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                    <a href="{{ route('admin.users.edit', $user) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
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