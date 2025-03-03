{{-- resources/views/admin/leave-requests/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Leave Request Details')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold">Leave Request Details</h1>
            <a href="{{ route('admin.leave-requests.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                <i class="fas fa-arrow-left mr-1"></i> Back to Leave Requests
            </a>
        </div>

        <div class="bg-gray-50 rounded-lg overflow-hidden shadow mb-6">
            <div class="px-4 py-5 sm:px-6 bg-gray-100">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    {{ $leaveRequest->type }} Leave
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Submitted by 
                    <a href="{{ route('admin.users.show', $leaveRequest->user) }}" class="text-blue-600 hover:text-blue-900">
                        {{ $leaveRequest->user->name }}
                    </a>
                    on {{ $leaveRequest->created_at->format('M d, Y') }}
                </p>
                <p class="mt-1 max-w-2xl text-sm text-gray-700">
                    @if($leaveRequest->status === 'pending')
                        <span class="px-2 py-1 text-xs font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full">
                            Pending
                        </span>
                    @elseif($leaveRequest->status === 'approved')
                        <span class="px-2 py-1 text-xs font-semibold leading-tight text-green-700 bg-green-100 rounded-full">
                            Approved by 
                            @if($leaveRequest->approver)
                                {{ $leaveRequest->approver->name }}
                            @else
                                Admin
                            @endif
                        </span>
                    @else
                        <span class="px-2 py-1 text-xs font-semibold leading-tight text-red-700 bg-red-100 rounded-full">
                            Rejected by 
                            @if($leaveRequest->approver)
                                {{ $leaveRequest->approver->name }}
                            @else
                                Admin
                            @endif
                        </span>
                    @endif
                </p>
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
                                Admin Comment
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $leaveRequest->admin_comment ?: 'No comment provided' }}
                            </dd>
                        </div>
                    @endif
                </dl>
            </div>
        </div>

        @if($leaveRequest->status === 'pending')
            <div class="bg-white rounded-lg overflow-hidden shadow mb-6 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Update Leave Request Status</h3>
                
                <form action="{{ route('admin.leave-requests.update', $leaveRequest) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="pending" {{ old('status', $leaveRequest->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ old('status', $leaveRequest->status) === 'approved' ? 'selected' : '' }}>Approve</option>
                                <option value="rejected" {{ old('status', $leaveRequest->status) === 'rejected' ? 'selected' : '' }}>Reject</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="admin_comment" class="block text-sm font-medium text-gray-700">Comment (Optional)</label>
                            <textarea name="admin_comment" id="admin_comment" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('admin_comment', $leaveRequest->admin_comment) }}</textarea>
                        </div>
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Update Status
                        </button>
                    </div>
                </form>
            </div>
        @endif

        <!-- Employee Information -->
        <div class="bg-white rounded-lg overflow-hidden shadow">
            <div class="px-4 py-5 sm:px-6 bg-gray-100">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Employee Information
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Details about the employee requesting leave
                </p>
            </div>
            <div class="border-t border-gray-200">
                <dl>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Name
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $leaveRequest->user->name }}
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Department
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $leaveRequest->user->department ?: 'Not Assigned' }}
                        </dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Position
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $leaveRequest->user->position ?: 'Not Assigned' }}
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Email
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $leaveRequest->user->email }}
                        </dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Phone Number
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $leaveRequest->user->phone_number ?: 'Not Provided' }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection
