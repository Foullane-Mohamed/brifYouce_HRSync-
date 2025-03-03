
@extends('layouts.app')

@section('title', 'Departments Management')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold">Departments Management</h1>
            <a href="{{ route('admin.departments.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                <i class="fas fa-plus mr-1"></i> Add New Department
            </a>
        </div>

        <div class="mb-4">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">Name</th>
                            <th scope="col" class="px-6 py-3">Code</th>
                            <th scope="col" class="px-6 py-3">Manager</th>
                            <th scope="col" class="px-6 py-3">Description</th>
                            <th scope="col" class="px-6 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($departments as $department)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $department->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $department->code }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $department->manager ? $department->manager->name : 'Not Assigned' }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ Str::limit($department->description, 50) ?: 'No description' }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.departments.show', $department) }}" class="px-3 py-1 text-blue-600 hover:text-blue-900">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.departments.edit', $department) }}" class="px-3 py-1 text-yellow-600 hover:text-yellow-900">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.departments.destroy', $department) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this department?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1 text-red-600 hover:text-red-900">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="bg-white border-b">
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                    No departments found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            {{ $departments->links() }}
        </div>
    </div>
</div>
@endsection