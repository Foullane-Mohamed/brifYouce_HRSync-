@extends('layouts.app')

@section('title', 'My Leave Requests')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold">My Leave Requests</h1>
            <a href="{{ route('employee.leave-requests.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                <i class="fas fa-plus mr-1"></i> New Leave Request
            </a>
        </div>
        
        <!-- Leave Balance Summary -->
        <div class="bg-gray-50 p-4 rounded-lg mb-6">
            <h2 class="text-lg font-semibold mb-3">Leave Balance Summary ({{ date('Y') }})</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                @php
                    $totalAnnualLeave = 20; // Example annual leave allowance
                    
                    $usedAnnual = Auth::user()->leaveRequests()
                        ->where('status', 'approved')
                        ->where('type', 'Annual')
                        ->whereYear('start_date', date('Y'))
                        ->get()
                        ->sum(function($request) {
                            return $request->start_date->diffInDays($request->end_date) + 1;
                        });
                    
                    $usedSick = Auth::user()->leaveRequests()
                        ->where('status', 'approved')
                        ->where('type', 'Sick')
                        ->whereYear('start_date', date('Y'))
                        ->get()
                        ->sum(function($request) {
                            return $request->start_date->diffInDays($request->end_date) + 1;
                        });
                    
                    $pendingLeaves = Auth::user()->leaveRequests()
                        ->where('status', 'pending')
                        ->whereYear('start_date', date('Y'))
                        ->get()
                        ->sum(function($request) {
                            return $request->start_date->diffInDays($request->end_date) + 1;
                        });
                @endphp
                
                <div class="bg-white p-3 rounded shadow">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-500 rounded-full p-2 mr-3">
                            <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Annual Leave Balance</p>
                            <p class="text-lg font-semibold">{{ $totalAnnualLeave - $usedAnnual }} / {{ $totalAnnualLeave }} days</p>
                        </div>
                    </div>
                    <div class="mt-2 bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ ($usedAnnual / $totalAnnualLeave) * 100 }}%"></div>
                    </div>
                </div>
                
                <div class="bg-white p-3 rounded shadow">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-red-500 rounded-full p-2 mr-3">
                            <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Sick Leave Used</p>
                            <p class="text-lg font-semibold">{{ $usedSick }} days</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white p-3 rounded shadow">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-yellow-500 rounded-full p-2 mr-3">
                            <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Pending Leave</p>
                            <p class="text-lg font-semibold">{{ $pendingLeaves }} days</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white p-3 rounded shadow">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-full p-2 mr-3">
                            <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Approved Leave</p>
                            <p class="text-lg font-semibold">{{ $usedAnnual + $usedSick }} days</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
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
                                    <a href="{{ route('employee.leave-requests.show', $leaveRequest) }}" class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr class="bg-white border-b">
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
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