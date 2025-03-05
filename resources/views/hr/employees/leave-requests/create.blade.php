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

        <!-- Leave Balance -->
        <div class="bg-gray-50 p-4 rounded-lg mb-6">
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
                
                $remainingAnnual = $totalAnnualLeave - $usedAnnual;
            @endphp
            
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-500 rounded-full p-2 mr-3">
                    <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-700">Available Annual Leave: <span class="font-semibold {{ $remainingAnnual > 5 ? 'text-green-600' : 'text-yellow-600' }}">{{ $remainingAnnual }} days</span> remaining out of {{ $totalAnnualLeave }} days</p>
                </div>
            </div>
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
                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" min="{{ date('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    @error('start_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- End Date -->
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                    <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" min="{{ old('start_date') ?: date('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    @error('end_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Duration (calculated) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Duration</label>
                    <div class="mt-1 block w-full py-2 px-3 bg-gray-100 rounded-md" id="duration-display">
                        Select dates to calculate duration
                    </div>
                </div>

                <!-- Empty column for alignment -->
                <div></div>

                <!-- Reason -->
                <div class="md:col-span-2">
                    <label for="reason" class="block text-sm font-medium text-gray-700">Reason</label>
                    <textarea name="reason" id="reason" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('reason') }}</textarea>
                    <p class="mt-1 text-xs text-gray-500">Please provide details about your leave request. For sick leave, you may need to provide a medical certificate upon return.</p>
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const durationDisplay = document.getElementById('duration-display');
        
        function updateDuration() {
            if (startDateInput.value && endDateInput.value) {
                const startDate = new Date(startDateInput.value);
                const endDate = new Date(endDateInput.value);
                
                if (endDate >= startDate) {
                    // Calculate the difference in days
                    const diffTime = Math.abs(endDate - startDate);
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1; // +1 to include both start and end days
                    
                    durationDisplay.textContent = diffDays + (diffDays === 1 ? ' day' : ' days');
                    
                    // Update end date min attribute
                    endDateInput.min = startDateInput.value;
                } else {
                    durationDisplay.textContent = 'End date must be after start date';
                    endDateInput.value = startDateInput.value;
                }
            } else {
                durationDisplay.textContent = 'Select dates to calculate duration';
            }
        }
        
        startDateInput.addEventListener('change', function() {
            if (endDateInput.value && new Date(endDateInput.value) < new Date(startDateInput.value)) {
                endDateInput.value = startDateInput.value;
            }
            endDateInput.min = startDateInput.value;
            updateDuration();
        });
        
        endDateInput.addEventListener('change', updateDuration);
        
        // Initial calculation if values are already set (e.g., from old input after validation error)
        updateDuration();
    });
</script>
@endpush
@endsection