
@extends('layouts.app')

@section('title', 'Department Details')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold">Department Details</h1>
            <div class="flex space-x-2">
                <a href="{{ route('admin.departments.edit', $department) }}" class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700">
                    <i class="fas fa-edit mr-1"></i> Edit
                </a>
                <a href="{{ route('admin.departments.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                    <i class="fas fa-arrow-left mr-1"></i> Back to Departments
                </a>
            </div>
        </div>

        <div class="bg-gray-50 rounded-lg overflow-hidden shadow">
            <div class="px-4 py-5 sm:px-6 bg-gray-100">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    {{ $department->name }}
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Code: {{ $department->code }}
                </p>
            </div>
            <div class="border-t border-gray-200">
                <dl>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Department Manager
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            @if($department->manager)
                                <a href="{{ route('admin.users.show', $department->manager) }}" class="text-blue-600 hover:text-blue-900">
                                    {{ $department->manager->name }}
                                </a>
                            @else
                                Not Assigned
                            @endif
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Description
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $department->description ?: 'No description provided' }}
                        </dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Created At
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $department->created_at->format('M d, Y H:i') }}
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Last Updated
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $department->updated_at->format('M d, Y H:i') }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Employees in this Department Section -->
        <div class="mt-8">
            <h2 class="text-xl font-semibold mb-4">Employees in {{ $department->name }}</h2>
            
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Position
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Email
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Employee ID
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse(App\Models\User::where('department', $department->name)->get() as $employee)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $employee->name }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $employee->position ?: 'Not Assigned' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $employee->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $employee->employee_id ?: 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <a href="{{ route('admin.users.show', $employee) }}" class="text-blue-600 hover:text-blue-900">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    No employees assigned to this department.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Danger Zone -->
        <div class="mt-10 p-4 bg-red-50 rounded-lg border border-red-200">
            <h3 class="text-lg font-medium text-red-800 mb-4">Danger Zone</h3>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-red-700">Delete this department</p>
                    <p class="text-xs text-red-500">This action cannot be undone. All data associated with this department will be permanently removed.</p>
                </div>
                <form action="{{ route('admin.departments.destroy', $department) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this department? This action cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        Delete Department
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection