
@extends('layouts.app')

@section('title', 'Attendance Records')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold">Attendance Records</h1>
            <div class="flex space-x-2">
                <form action="{{ route('hr.attendance.index') }}" method="GET" class="flex space-x-2">
                    <input type="date" name="date" value="{{ request('date', date('Y-m-d')) }}" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        <i class="fas fa-filter mr-1"></i> Filter
                    </button>
                </form>
                <a href="{{ route('hr.attendance.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                    <i class="fas fa-plus mr-1"></i> Add Attendance
                </a>
            </div>
        </div>

        <div class="mb-4">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">Employee</th>
                            <th scope="col" class="px-6 py-3">Date</th>
                            <th scope="col" class="px-6 py-3">Clock In</th>
                            <th scope="col" class="px-6 py-3">Clock Out</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-6 py-3">Remarks</th>
                            <th scope="col" class="px-6 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($attendanceRecords as $record)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    <a href="{{ route('hr.employees.show', $record->user) }}" class="text-blue-600 hover:text-blue-900">
                                        {{ $record->user->name }}
                                    </a>
                                </td>
                                <td class="px-6 py-4">
                                    {{ $record->date->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $record->clock_in ? date('h:i A', strtotime($record->clock_in)) : 'N/A' }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $record->clock_out ? date('h:i A', strtotime($record->clock_out)) : 'N/A' }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($record->status === 'present')
                                        <span class="px-2 py-1 text-xs font-semibold leading-tight text-green-700 bg-green-100 rounded-full">
                                            Present
                                        </span>
                                    @elseif($record->status === 'absent')
                                        <span class="px-2 py-1 text-xs font-semibold leading-tight text-red-700 bg-red-100 rounded-full">
                                            Absent
                                        </span>
                                    @elseif($record->status === 'late')
                                        <span class="px-2 py-1 text-xs font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full">
                                            Late
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold leading-tight text-gray-700 bg-gray-100 rounded-full">
                                            {{ ucfirst($record->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    {{ $record->remarks ?: 'No remarks' }}
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('hr.attendance.edit', $record) }}" class="text-yellow-600 hover:text-yellow-900">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr class="bg-white border-b">
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                    No attendance records found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            {{ $attendanceRecords->links() }}
        </div>
    </div>
</div>
@endsection