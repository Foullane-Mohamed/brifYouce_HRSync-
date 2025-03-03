{{-- resources/views/employee/leave-requests/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Submit Leave Request')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold">Submit Leave Request</h1>
            <a href="{{ route('employee.leave-requests.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                <i class="fas fa-arrow-left mr-1"></i> Back to Leave Requests
            </a>
        </div>

        <form action="{{ route('employee.leave-requests.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Leave Type -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700">Leave Type</label>
                    <select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        <option value="">Select Leave Type</option>
                        <option value="Annual" {{ old('type') == 'Annual' ? 'selected' : '' }}>Annual Leave</option>
                        <option value="Sick" {{ old('type') == 'Sick' ? 'selected' : '' }}>Sick Leave</option>
                        <option value="Personal" {{ old('type') == 'Personal' ? 'selected' : '' }}>Personal Leave</option>
                        <option value="Bereavement" {{ old('type') == 'Bereavement' ? 'selected' : '' }}>Bereavement Leave</option>
                        <option value="Unpaid" {{ old('type') == 'Unpaid' ? 'selected' : '' }}>Unpaid Leave</option>
                    </select>
                    @error('type')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Empty column for alignment -->
                <div></div>

                <!-- Start Date -->
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    @error('start_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- End Date -->
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                    <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    @error('end_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Reason -->
                <div class="md:col-span-2">
                    <label for="reason" class="block text-sm font-medium text-gray-700">Reason</label>
                    <textarea name="reason" id="reason" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('reason') }}</textarea>
                    @error('reason')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-end mt-4">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Submit Leave Request
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        
        // Set min value for start date to today
        startDateInput.min = new Date().toISOString().split('T')[0];
        
        startDateInput.addEventListener('change', function() {
            // Set min value for end date to start date
            endDateInput.min = startDateInput.value;
            
            // If end date is before start date, update end date
            if (endDateInput.value && new Date(endDateInput.value) < new Date(startDateInput.value)) {
                endDateInput.value = startDateInput.value;
            }
        });
    });
</script>
@endpush