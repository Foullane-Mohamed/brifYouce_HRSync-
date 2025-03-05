@extends('layouts.app')

@section('title', 'Edit Attendance Record')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold">Edit Attendance Record</h1>
            <a href="{{ route('hr.attendance.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                <i class="fas fa-arrow-left mr-1"></i> Back to Attendance
            </a>
        </div>

        <form action="{{ route('hr.attendance.update', $attendanceRecord) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Employee (read-only) -->
                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-700">Employee</label>
                    <div class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-gray-100 rounded-md shadow-sm">
                        {{ $attendanceRecord->user->name }} - {{ $attendanceRecord->user->employee_id ?: 'No ID' }}
                    </div>
                    <input type="hidden" name="user_id" value="{{ $attendanceRecord->user_id }}">
                </div>

                <!-- Date -->
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                    <input type="date" name="date" id="date" value="{{ old('date', $attendanceRecord->date->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    @error('date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Clock In -->
                <div>
                    <label for="clock_in" class="block text-sm font-medium text-gray-700">Clock In Time</label>
                    <input type="time" name="clock_in" id="clock_in" value="{{ old('clock_in', $attendanceRecord->clock_in ? date('H:i', strtotime($attendanceRecord->clock_in)) : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('clock_in')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Clock Out -->
                <div>
                    <label for="clock_out" class="block text-sm font-medium text-gray-700">Clock Out Time</label>
                    <input type="time" name="clock_out" id="clock_out" value="{{ old('clock_out', $attendanceRecord->clock_out ? date('H:i', strtotime($attendanceRecord->clock_out)) : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('clock_out')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Break Start -->
                <div>
                    <label for="break_start" class="block text-sm font-medium text-gray-700">Break Start Time</label>
                    <input type="time" name="break_start" id="break_start" value="{{ old('break_start', $attendanceRecord->break_start ? date('H:i', strtotime($attendanceRecord->break_start)) : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('break_start')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Break End -->
                <div>
                    <label for="break_end" class="block text-sm font-medium text-gray-700">Break End Time</label>
                    <input type="time" name="break_end" id="break_end" value="{{ old('break_end', $attendanceRecord->break_end ? date('H:i', strtotime($attendanceRecord->break_end)) : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('break_end')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        <option value="present" {{ old('status', $attendanceRecord->status) === 'present' ? 'selected' : '' }}>Present</option>
                        <option value="absent" {{ old('status', $attendanceRecord->status) === 'absent' ? 'selected' : '' }}>Absent</option>
                        <option value="late" {{ old('status', $attendanceRecord->status) === 'late' ? 'selected' : '' }}>Late</option>
                        <option value="half_day" {{ old('status', $attendanceRecord->status) === 'half_day' ? 'selected' : '' }}>Half Day</option>
                        <option value="leave" {{ old('status', $attendanceRecord->status) === 'leave' ? 'selected' : '' }}>On Leave</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remarks -->
                <div class="md:col-span-2">
                    <label for="remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                    <textarea name="remarks" id="remarks" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('remarks', $attendanceRecord->remarks) }}</textarea>
                    @error('remarks')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-end mt-4">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Update Attendance Record
                </button>
            </div>
        </form>
    </div>
</div>
@endsection