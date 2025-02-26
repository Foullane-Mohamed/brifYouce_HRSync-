<x-app-layout>
  <x-slot name="header">
      <div class="flex justify-between items-center">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              {{ __('Departments') }}
          </h2>
          @can('create', App\Models\Department::class)
              <a href="{{ route('departments.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                  {{ __('Add Department') }}
              </a>
          @endcan
      </div>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
              <div class="p-6 bg-white border-b border-gray-200">
                  <div class="overflow-x-auto">
                      <table class="min-w-full divide-y divide-gray-200">
                          <thead class="bg-gray-50">
                              <tr>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                      {{ __('Name') }}
                                  </th>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                      {{ __('Company') }}
                                  </th>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                      {{ __('Employees') }}
                                  </th>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                      {{ __('Description') }}
                                  </th>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                      {{ __('Actions') }}
                                  </th>
                              </tr>
                          </thead>
                          <tbody class="bg-white divide-y divide-gray-200">
                              @forelse($departments as $department)
                                  <tr>
                                      <td class="px-6 py-4 whitespace-nowrap">
                                          <div class="text-sm font-medium text-gray-900">
                                              {{ $department->name }}
                                          </div>
                                      </td>
                                      <td class="px-6 py-4 whitespace-nowrap">
                                          <div class="text-sm text-gray-500">
                                              {{ $department->company->name }}
                                          </div>
                                      </td>
                                      <td class="px-6 py-4 whitespace-nowrap">
                                          <div class="text-sm text-gray-500">
                                              {{ $department->employees->count() }}
                                          </div>
                                      </td>
                                      <td class="px-6 py-4">
                                          <div class="text-sm text-gray-500 truncate max-w-xs">
                                              {{ $department->description ?: 'N/A' }}
                                          </div>
                                      </td>
                                      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                          <div class="flex space-x-2">
                                              <a href="{{ route('departments.show', $department) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                              @can('update', $department)
                                                  <a href="{{ route('departments.edit', $department) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                              @endcan
                                              @can('delete', $department)
                                                  <form action="{{ route('departments.destroy', $department) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this department?');">
                                                      @csrf
                                                      @method('DELETE')
                                                      <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                                  </form>
                                              @endcan
                                          </div>
                                      </td>
                                  </tr>
                              @empty
                                  <tr>
                                      <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                          {{ __('No departments found.') }}
                                      </td>
                                  </tr>
                              @endforelse
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
      </div>
  </div>
</x-app-layout>