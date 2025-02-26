<x-app-layout>
  <x-slot name="header">
      <div class="flex justify-between items-center">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              {{ $department->name }} - {{ __('Department') }}
          </h2>
          <div class="flex space-x-2">
              @can('update', $department)
                  <a href="{{ route('departments.edit', $department) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-500 active:bg-yellow-700 focus:outline-none focus:border-yellow-700 focus:ring focus:ring-yellow-300 disabled:opacity-25 transition">
                      {{ __('Edit') }}
                  </a>
              @endcan
              <a href="{{ route('departments.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                  {{ __('Back to Departments') }}
              </a>
          </div>
      </div>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
              <div class="p-6 bg-white border-b border-gray-200">
                  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                      <div class="md:col-span-1">
                          <h3 class="text-lg font-semibold text-gray-700 mb-4">{{ __('Department Information') }}</h3>
                          <div class="space-y-4">
                              <div>
                                  <span class="text-sm text-gray-500">{{ __('Department Name') }}</span>
                                  <p class="text-gray-800">{{ $department->name }}</p>
                              </div>
                              <div>
                                  <span class="text-sm text-gray-500">{{ __('Company') }}</span>
                                  <p class="text-gray-800">
                                      <a href="{{ route('companies.show', $department->company) }}" class="text-indigo-600 hover:text-indigo-900">
                                          {{ $department->company->name }}
                                      </a>
                                  </p>
                              </div>
                              <div>
                                  <span class="text-sm text-gray-500">{{ __('Number of Employees') }}</span>
                                  <p class="text-gray-800">{{ $department->employees->count() }}</p>
                              </div>
                              <div>
                                  <span class="text-sm text-gray-500">{{ __('Description') }}</span>
                                  <p class="text-gray-800">{{ $department->description ?: 'N/A' }}</p>
                              </div>
                          </div>
                      </div>

                      <div class="md:col-span-2">
                          <h3 class="text-lg font-semibold text-gray-700 mb-4">{{ __('Employees') }}</h3>
                          @if($department->employees->count() > 0)
                              <div class="overflow-x-auto">
                                  <table class="min-w-full divide-y divide-gray-200">
                                      <thead class="bg-gray-50">
                                          <tr>
                                              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                  {{ __('Name') }}
                                              </th>
                                              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                  {{ __('Position') }}
                                              </th>
                                              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                  {{ __('Email') }}
                                              </th>
                                              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                  {{ __('Hire Date') }}
                                              </th>
                                              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                  {{ __('Actions') }}
                                              </th>
                                          </tr>
                                      </thead>
                                      <tbody class="bg-white divide-y divide-gray-200">
                                          @foreach($department->employees as $employee)
                                              <tr>
                                                  <td class="px-6 py-4 whitespace-nowrap">
                                                      <div class="text-sm font-medium text-gray-900">
                                                          {{ $employee->user->name }}
                                                      </div>
                                                  </td>
                                                  <td class="px-6 py-4 whitespace-nowrap">
                                                      <div class="text-sm text-gray-500">
                                                          {{ $employee->position ?: 'N/A' }}
                                                      </div>
                                                  </td>
                                                  <td class="px-6 py-4 whitespace-nowrap">
                                                      <div class="text-sm text-gray-500">
                                                          {{ $employee->user->email }}
                                                      </div>
                                                  </td>
                                                  <td class="px-6 py-4 whitespace-nowrap">
                                                      <div class="text-sm text-gray-500">
                                                          {{ $employee->hire_date ? $employee->hire_date->format('M d, Y') : 'N/A' }}
                                                      </div>
                                                  </td>
                                                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                      <a href="{{ route('employees.show', $employee) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                                  </td>
                                              </tr>
                                          @endforeach
                                      </tbody>
                                  </table>
                              </div>
                          @else
                              <p class="text-gray-500 text-sm">{{ __('No employees found in this department.') }}</p>
                          @endif
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</x-app-layout>