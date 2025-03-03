
@extends('layouts.app')

@section('title', 'Users Management')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold">Users Management</h1>
            <a href="{{ route('admin.users.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                <i class="fas fa-plus mr-1"></i> Add New User
            </a>
        </div>

        <div class="mb-4">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">Name</th>
                            <th scope="col" class="px-6 py-3">Email</th>
                            <th scope="col" class="px-6 py-3">Role</th>
                            <th scope="col" class="px-6 py-3">Employee ID</th>
                            <th scope="col" class="px-6 py-3">Department</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-6 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $user->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $user->email }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $user->role ? $user->role->name : 'No Role' }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $user->employee_id ?: 'N/A' }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $user->department ?: 'N/A' }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($user->is_active)
                                        <span class="px-2 py-1 text-xs font-semibold leading-tight text-green-700 bg-green-100 rounded-full">
                                            Active
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold leading-tight text-red-700 bg-red-100 rounded-full">
                                            Inactive
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.users.show', $user) }}" class="px-3 py-1 text-blue-600 hover:text-blue-900">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.users.edit', $user) }}" class="px-3 py-1 text-yellow-600 hover:text-yellow-900">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
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
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                    No users found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection