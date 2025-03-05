{{-- resources/views/employee/attendance/index.blade.php --}}
@extends('layouts.app')

@section('title', 'My Attendance Records')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold">My Attendance Records</h1>
            <div class="flex space-x-2">
                <form action="{{ route('employee.attendance.index') }}" method="GET" class="flex">
                    <input type="month" name="month" value="{{ request('month', date('Y-m')) }}" class="rounded-l-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-r-md hover:bg-blue-700">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Attendance Summary -->
        <div class="bg-gray-50 p-4 rounded-lg mb-6">
            <h2 class="text-lg font-semibold mb-3">Attendance Summary ({{ request('month', date('F Y')) }})</h2>
            
            @php
                $month = request('month') ? date('m', strtotime(request('month'))) : date('m');
                $year = request('month') ? date('Y', strtotime(request('month'))) : date('Y');
                
                $totalWorkingDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                $weekends = 0;
                
                for ($day = 1; $day <= $totalWorkingDays; $day++) {
                    $date = new DateTime("$year-$month-$day");
                    $dayOfWeek = $date->format('N');
                    
                    if ($dayOfWeek >= 6) { // 6 = Saturday, 7 = Sunday
                        $weekends++;
                    }
                }
                
                $workingDays = $totalWorkingDays - $weekends;
                
                $attendanceRecords = $attendanceRecords ?? Auth::user()->attendanceRecords()
                    ->whereMonth('date', $month)
                    ->whereYear('date', $year)
                    ->get();
                
                $presentDays = $attendanceRecords->where('status', 'present')->count();
                $lateDays = $attendanceRecords->where('status', 'late')->count();
                $absentDays = $attendanceRecords->where('status', 'absent')->count();
                $leaveDays = $attendanceRecords->where('status', 'leave')->count();
                
                $presentPercentage = $workingDays > 0 ? round(($presentDays / $workingDays) * 100) : 0;
            @endphp
            
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div class="bg-white p-3 rounded shadow">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-500 rounded-full p-2 mr-3">
                            <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Working Days</p>
                            <p class="text-lg font-semibold">{{ $workingDays }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white p-3 rounded shadow">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-full p-2 mr-3">
                            <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Present</p>
                            <p class="text-lg font-semibold">{{ $presentDays }}</p>
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
                            <p class="text-xs text-gray-500">Late</p>
                            <p class="text-lg font-semibold">{{ $lateDays }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white p-3 rounded shadow">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-red-500 rounded-full p-2 mr-3">
                            <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Absent</p>
                            <p class="text-lg font-semibold">{{ $absentDays }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white p-3 rounded shadow">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-500 rounded-full p-2 mr-3">
                            <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">On Leave</p>
                            <p class="text-lg font-semibold">{{ $leaveDays }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-4">
                <p class="text-sm font-medium mb-2">Attendance Rate: {{ $presentPercentage }}%</p>
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $presentPercentage }}%"></div>
                </div>
            </div>
        </div>
        
        <!-- Today's Attendance Status -->
        @php
            $today = now()->toDateString();
            $todayAttendance = Auth::user()->attendanceRecords()
                ->whereDate('date', $today)
                ->first();
        @endphp
        
        @if($todayAttendance)
            <div class="mb-6 p-4 rounded-lg {{ $todayAttendance->status === 'present' ? 'bg-green-50' : ($todayAttendance->status === 'late' ? 'bg-yellow-50' : 'bg-red-50') }}">
                <h3 class="text-lg font-medium {{ $todayAttendance->status === 'present' ? 'text-green-700' : ($todayAttendance->status === 'late' ? 'text-yellow-700' : 'text-red-700') }} mb-2">
                    Today's Attendance: {{ ucfirst($todayAttendance->status) }}
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <span class="block text-sm text-gray-500">Clock In:</span>
                        <span class="block text-base font-medium">{{ $todayAttendance->clock_in ? date('h:i A', strtotime($todayAttendance->clock_in)) : 'N/A' }}</span>
                    </div>
                    
                    <div>
                        <span class="block text-sm text-gray-500">Clock Out:</span>
                        <span class="block text-base font-medium">{{ $todayAttendance->clock_out ? date('h:i A', strtotime($todayAttendance->clock_out)) : 'N/A' }}</span>
                    </div>
                    
                    <div>
                        <span class="block text-sm text-gray-500">Total Hours:</span>
                        <span class="block text-base font-medium">
                            @if($todayAttendance->clock_in && $todayAttendance->clock_out)
                                @php
                                    $clockIn = new DateTime($todayAttendance->clock_in);
                                    $clockOut = new DateTime($todayAttendance->clock_out);
                                    $interval = $clockIn->diff($clockOut);
                                    echo $interval->format('%H hours, %I minutes');
                                @endphp
                            @else
                                N/A
                            @endif
                        </span>
                    </div>
                </div>
                
                @if(!$todayAttendance->clock_out && $todayAttendance->clock_in)
                    <div class="mt-3">
                        <form action="{{ route('employee.attendance.clock-out') }}" method="POST">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                                <i class="fas fa-sign-out-alt mr-2"></i> Clock Out
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        @elseif(now()->format('N') < 6) {{-- If today is not weekend (1-5 is Monday to Friday) --}}
            <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                <h3 class="text-lg font-medium text-blue-700 mb-2">Today's Attendance</h3>
                <p class="text-blue-600 mb-3">You haven't clocked in today.</p>
                
                <form action="{{ route('employee.attendance.clock-in') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        <i class="fas fa-sign-in-alt mr-2"></i> Clock In
                    </button>
                </form>
            </div>
        @endif

        <div class="mb-4">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">Date</th>
                            <th scope="col" class="px-6 py-3">Day</th>
                            <th scope="col" class="px-6 py-3">Clock In</th>
                            <th scope="col" class="px-6 py-3">Clock Out</th>
                            <th scope="col" class="px-6 py-3">Total Hours</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($attendanceRecords as $record)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $record->date->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $record->date->format('l') }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $record->clock_in ? date('h:i A', strtotime($record->clock_in)) : 'N/A' }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $record->clock_out ? date('h:i A', strtotime($record->clock_out)) : 'N/A' }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($record->clock_in && $record->clock_out)
                                        @php
                                            $clockIn = new DateTime($record->clock_in);
                                            $clockOut = new DateTime($record->clock_out);
                                            $interval = $clockIn->diff($clockOut);
                                            echo $interval->format('%H:%I');
                                        @endphp
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($record->status === 'present')
                                        <span class="px-2 py-1 text-xs font-semibold leading-tight text-green-700 bg-green-100 rounded-full">
                                            Present
                                        </span>
                                    @elseif($record->status === 'late')
                                        <span class="px-2 py-1 text-xs font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full">
                                            Late
                                        </span>
                                    @elseif($record->status === 'absent')
                                        <span class="px-2 py-1 text-xs font-semibold leading-tight text-red-700 bg-red-100 rounded-full">
                                            Absent
                                        </span>
                                    @elseif($record->status === 'leave')
                                        <span class="px-2 py-1 text-xs font-semibold leading-tight text-purple-700 bg-purple-100 rounded-full">
                                            On Leave
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold leading-tight text-gray-700 bg-gray-100 rounded-full">
                                            {{ ucfirst($record->status) }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr class="bg-white border-b">
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                    No attendance records found for this month.
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