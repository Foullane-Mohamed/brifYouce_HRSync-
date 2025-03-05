@extends('layouts.app')

@section('title', 'Leave Request Details')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold">Leave Request Details</h1>
            <a href="{{ route('employee.leave-requests.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                <i class="fas fa-arrow-left mr-1"></i> Back to Leave Requests
            </a>
        </div>

        <div class="bg-gray-50 rounded-lg overflow-hidden shadow mb-6">
            <div class="px-4 py-5 sm:px-6 bg-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            {{ $leaveRequest->type }} Leave
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            Submitted on {{ $leaveRequest->created_at->format('M d, Y') }}
                        </p>
                    </div>
                    
                    <div>
                        @if($leaveRequest->status === 'pending')
                            <span class="px-4 py-2 text-sm font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full">
                                Pending Approval
                            </span>
                        @elseif($leaveRequest->status === 'approved')
                            <span class="px-4 py-2 text-sm font-semibold leading-tight text-green-700 bg-green-100 rounded-full">
                                Approved
                            </span>
                        @else
                            <span class="px-4 py-2 text-sm font-semibold leading-tight text-red-700 bg-red-100 rounded-full">
                                Rejected
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-200">
                <dl>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Leave Period
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $leaveRequest->start_date->format('M d, Y') }} to {{ $leaveRequest->end_date->format('M d, Y') }}
                            ({{ $leaveRequest->start_date->diffInDays($leaveRequest->end_date) + 1 }} days)
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Reason
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $leaveRequest->reason ?: 'No reason provided' }}
                        </dd>
                    </div>
                    @if($leaveRequest->status !== 'pending')
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Response Date
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $leaveRequest->updated_at->format('M d, Y') }}
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Approved/Rejected By
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $leaveRequest->approver ? $leaveRequest->approver->name : 'System' }}
                            </dd>
                        </div>
                        @if($leaveRequest->admin_comment)
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">
                                    Comments
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $leaveRequest->admin_comment }}
                                </dd>
                            </div>
                        @endif
                    @endif
                </dl>
            </div>
        </div>

        <!-- Status Timeline -->
        <div class="mb-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Request Timeline</h3>
            
            <div class="relative pb-8">
                <div class="absolute h-full w-0.5 bg-gray-200 left-6"></div>
                
                <!-- Submitted -->
                <div class="relative flex items-start mb-6">
                    <div class="h-12 w-12 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 z-10">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-base font-medium text-gray-900">Request Submitted</h4>
                        <p class="text-sm text-gray-500">{{ $leaveRequest->created_at->format('M d, Y h:i A') }}</p>
                        <p class="text-sm text-gray-600 mt-1">You submitted a request for {{ $leaveRequest->type }} leave.</p>
                    </div>
                </div>
                
                <!-- Pending/In Review -->
                <div class="relative flex items-start mb-6">
                    <div class="h-12 w-12 flex items-center justify-center rounded-full {{ $leaveRequest->status === 'pending' ? 'bg-yellow-100 text-yellow-600' : 'bg-gray-100 text-gray-400' }} z-10">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-base font-medium text-gray-900">Under Review</h4>
                        <p class="text-sm text-gray-500">{{ $leaveRequest->created_at->format('M d, Y h:i A') }}</p>
                        <p class="text-sm {{ $leaveRequest->status === 'pending' ? 'text-yellow-600' : 'text-gray-600' }} mt-1">
                            {{ $leaveRequest->status === 'pending' ? 'Your request is currently under review.' : 'Your request has been reviewed.' }}
                        </p>
                    </div>
                </div>
                
                <!-- Approved/Rejected -->
                @if($leaveRequest->status !== 'pending')
                    <div class="relative flex items-start">
                        <div class="h-12 w-12 flex items-center justify-center rounded-full {{ $leaveRequest->status === 'approved' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }} z-10">
                            @if($leaveRequest->status === 'approved')
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            @else
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            @endif
                        </div>
                        <div class="ml-4">
                            <h4 class="text-base font-medium text-gray-900">
                                {{ $leaveRequest->status === 'approved' ? 'Request Approved' : 'Request Rejected' }}
                            </h4>
                            <p class="text-sm text-gray-500">{{ $leaveRequest->updated_at->format('M d, Y h:i A') }}</p>
                            <p class="text-sm {{ $leaveRequest->status === 'approved' ? 'text-green-600' : 'text-red-600' }} mt-1">
                                {{ $leaveRequest->status === 'approved' ? 'Your leave request has been approved.' : 'Your leave request has been rejected.' }}
                                @if($leaveRequest->admin_comment)
                                    <span class="text-gray-600"> Comment: "{{ $leaveRequest->admin_comment }}"</span>
                                @endif
                            </p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Previous Requests -->
        <div class="mt-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Your Recent Leave Requests</h3>
            
            @php
                $previousRequests = Auth::user()->leaveRequests()
                    ->where('id', '!=', $leaveRequest->id)
                    ->orderBy('created_at', 'desc')
                    ->take(3)
                    ->get();
            @endphp
            
            @if($previousRequests->isEmpty())
                <p class="text-gray-500 italic">No previous leave requests found.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dates</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($previousRequests as $prevRequest)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $prevRequest->type }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $prevRequest->start_date->format('M d, Y') }} - {{ $prevRequest->end_date->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $prevRequest->start_date->diffInDays($prevRequest->end_date) + 1 }} days
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($prevRequest->status === 'pending')
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Pending
                                            </span>
                                        @elseif($prevRequest->status === 'approved')
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Approved
                                            </span>
                                        @else
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Rejected
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('employee.leave-requests.show', $prevRequest) }}" class="text-indigo-600 hover:text-indigo-900">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
            
            <div class="mt-4 text-right">
                <a href="{{ route('employee.leave-requests.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
                    View all leave requests <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection