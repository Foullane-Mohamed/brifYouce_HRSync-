{{-- resources/views/hr/leave-requests/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Leave Request Details')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold">Leave Request Details</h1>
            <a href="{{ route('hr.leave-requests.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
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
                    <a href="{{ route('hr.employees.show', $leaveRequest->user) }}" class="text-blue-600 hover:text-blue-900">
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
                                HR
                            @endif
                        </span>
                    @else
                        <span class="px-2 py-1 text-xs font-semibold leading-tight text-red-700 bg-red-100 rounded-full">
                            Rejected by 
                            @if($leaveRequest->approver)
                                {{ $leaveRequest->approver->name }}
                            @else
                                HR
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
                                HR Comment
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
                
                <form action="{{ route('hr.leave-requests.update', $leaveRequest) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 gap-6 mb-4">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <div class="mt-1">
                                <div class="flex space-x-4">
                                    <div class="flex items-center">
                                        <input id="approved" name="status" type="radio" value="approved" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                        <label for="approved" class="ml-2 block text-sm text-gray-700">
                                            Approve
                                        </label>
                                    </div>
                                    <div class="flex items-center">
                                        <input id="rejected" name="status" type="radio" value="rejected" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                        <label for="rejected" class="ml-2 block text-sm text-gray-700">
                                            Reject
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @error('status')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="admin_comment" class="block text-sm font-medium text-gray-700">Comment (Optional)</label>
                            <textarea name="admin_comment" id="admin_comment" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                            @error('admin_comment')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
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
                            <a href="{{ route('hr.employees.show', $leaveRequest->user) }}" class="text-blue-600 hover:text-blue-900">
                                {{ $leaveRequest->user->name }}
                            </a>
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
        
        <!-- Leave History -->
        <div class="mt-8">
            <h2 class="text-xl font-semibold mb-4">Leave History</h2>
            
            @php
                $previousLeaves = $leaveRequest->user->leaveRequests()
                    ->where('id', '!=', $leaveRequest->id)
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get();
            @endphp
            
            @if($previousLeaves->isEmpty())
                <p class="text-gray-500 italic">No previous leave requests found for this employee.</p>
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
                            @foreach($previousLeaves as $prevLeave)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $prevLeave->type }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $prevLeave->start_date->format('M d, Y') }} - {{ $prevLeave->end_date->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $prevLeave->start_date->diffInDays($prevLeave->end_date) + 1 }} days
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($prevLeave->status === 'pending')
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Pending
                                            </span>
                                        @elseif($prevLeave->status === 'approved')
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
                                        <a href="{{ route('hr.leave-requests.show', $prevLeave) }}" class="text-indigo-600 hover:text-indigo-900">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection