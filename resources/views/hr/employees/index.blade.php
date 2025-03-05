{{-- resources/views/hr/leave-requests/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Leave Requests Management')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold">Leave Requests Management</h1>
            <div>
                <form action="{{ route('hr.leave-requests.index') }}" method="GET" class="flex items-center space-x-2">
                    <div>
                        <select name="status" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        <i class="fas fa-filter mr-1"></i> Filter
                    </button>
                </form>
            </div>
        </div>

        <div class="mb-4">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">Employee</th>
                            <th scope="col" class="px-6 py-3">Type</th>
                            <th scope="col" class="px-6 py-3">Start Date</th>
                            <th scope="col" class="px-6 py-3">End Date</th>
                            <th scope="col" class="px-6 py-3">Duration</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-6 py-3">Submitted On</th>
                            <th scope="col" class="px-6 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($leaveRequests as $leaveRequest)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $leaveRequest->user->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $leaveRequest->type }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $leaveRequest->start_date->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $leaveRequest->end_date->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $leaveRequest->start_date->diffInDays($leaveRequest->end_date) + 1 }} days
                                </td>
                                <td class="px-6 py-4">
                                    @if($leaveRequest->status === 'pending')
                                        <span class="px-2 py-1 text-xs font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full">
                                            Pending
                                        </span>
                                    @elseif($leaveRequest->status === 'approved')
                                        <span class="px-2 py-1 text-xs font-semibold leading-tight text-green-700 bg-green-100 rounded-full">
                                            Approved
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold leading-tight text-red-700 bg-red-100 rounded-full">
                                            Rejected
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    {{ $leaveRequest->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('hr.leave-requests.show', $leaveRequest) }}" class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr class="bg-white border-b">
                                <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                    No leave requests found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            {{ $leaveRequests->links() }}
        </div>
    </div>
</div>
@endsection