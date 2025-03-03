
@extends('layouts.app')

@section('title', 'Create Department')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold">Create New Department</h1>
            <a href="{{ route('admin.departments.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                <i class="fas fa-arrow-left mr-1"></i> Back to Departments
            </a>
        </div>

        <form action="{{ route('admin.departments.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Department Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Code -->
                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700">Department Code</label>
                    <input type="text" name="code" id="code" value="{{ old('code') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    <p class="text-xs text-gray-500 mt-1">A unique code for the department (e.g., HR, IT, FIN)</p>
                    @error('code')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Department Manager -->
                <div>
                    <label for="manager_id" class="block text-sm font-medium text-gray-700">Department Manager</label>
                    <select name="manager_id" id="manager_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Select Manager (Optional)</option>
                        @foreach($managers as $manager)
                            <option value="{{ $manager->id }}" {{ old('manager_id') == $manager->id ? 'selected' : '' }}>
                                {{ $manager->name }} - {{ $manager->employee_id ?: 'No ID' }}
                            </option>
                        @endforeach
                    </select>
                    @error('manager_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Placeholder for grid alignment -->
                <div></div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-end mt-4">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Create Department
                </button>
            </div>
        </form>
    </div>
</div>
@endsection