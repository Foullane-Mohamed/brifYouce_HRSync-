<x-app-layout>
  <x-slot name="header">
      <div class="flex justify-between items-center">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              {{ $company->name }}
          </h2>
          <div class="flex space-x-2">
              @can('update', $company)
                  <a href="{{ route('companies.edit', $company) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-500 active:bg-yellow-700 focus:outline-none focus:border-yellow-700 focus:ring focus:ring-yellow-300 disabled:opacity-25 transition">
                      {{ __('Edit') }}
                  </a>
              @endcan
              <a href="{{ route('companies.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                  {{ __('Back to Companies') }}
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
                          <div class="flex flex-col items-center">
                              @if($company->getFirstMediaUrl('logos'))
                                  <img src="{{ $company->getFirstMediaUrl('logos') }}" alt="{{ $company->name }}" class="h-40 w-40 object-cover rounded-lg mb-4">
                              @else
                                  <div class="h-40 w-40 rounded-lg bg-gray-200 flex items-center justify-center mb-4">
                                      <span class="text-gray-500 text-4xl">{{ substr($company->name, 0, 1) }}</span>
                                  </div>
                              @endif
                              <h3 class="text-xl font-bold text-gray-900">{{ $company->name }}</h3>
                          </div>

                          <div class="mt-6">
                              <h4 class="text-lg font-semibold text-gray-700 mb-2">{{ __('Contact Information') }}</h4>
                              <div class="space-y-2">
                                  <div class="flex items-center">
                                      <svg class="h-5 w-5 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                      </svg>
                                      <span class="text-gray-600">{{ $company->email }}</span>
                                  </div>
                                  <div class="flex items-center">
                                      <svg class="h-5 w-5 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                      </svg>
                                      <span class="text-gray-600">{{ $company->phone ?: 'N/A' }}</span>
                                  </div>
                                  <div class="flex items-start">
                                      <svg class="h-5 w-5 text-gray-500 mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                      </svg>
                                      <span class="text-gray-600">{{ $company->address ?: 'N/A' }}</span>
                                  </div>
                              </div>
                          </div>
                      </div>

                      <div class="md:col-span-2">
                          <div>
                              <h4 class="text-lg font-semibold text-gray-700 mb-4">{{ __('Departments') }} ({{ $company->departments->count() }})</h4>
                              @if($company->departments->count() > 0)
                                  <div class="overflow-x-auto">
                                      <table class="min-w-full divide-y divide-gray-200">
                                          <thead class="bg-gray-50">
                                              <tr>
                                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                      {{ __('Name') }}
                                                  </th>
                                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                      {{ __('Employees') }}
                                                  </th>
                                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                      {{ __('Actions') }}
                                                  </th>
                                              </tr>
                                          </thead>
                                          <tbody class="bg-white divide-y divide-gray-200">
                                              @foreach($company->departments as $department)
                                                  <tr>
                                                      <td class="px-6 py-4 whitespace-nowrap">
                                                          <div class="text-sm font-medium text-gray-900">
                                                              {{ $department->name }}
                                                          </div>
                                                      </td>
                                                      <td class="px-6 py-4 whitespace-nowrap">
                                                          <div class="text-sm text-gray-500">
                                                              {{ $department->employees->count() }}
                                                          </div>
                                                      </td>
                                                      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                          <a href="{{ route('departments.show', $department) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                                      </td>
                                                  </tr>
                                              @endforeach
                                          </tbody>
                                      </table>
                                  </div>
                              @else
                                  <p class="text-gray-500 text-sm">{{ __('No departments found.') }}</p>
                              @endif
                          </div>

                          <div class="mt-8">
                              <h4 class="text-lg font-semibold text-gray-700 mb-4">{{ __('Employees') }} ({{ $company->employees->count() }})</h4>
                              @if($company->employees->count() > 0)
                                  <div class="overflow-x-auto">
                                      <table class="min-w-full divide-y divide-gray-200">
                                          <thead class="bg-gray-50">
                                              <tr>
                                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                      {{ __('Name') }}
                                                  </th>
                                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                      {{ __('Email') }}
                                                  </th>
                                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                      {{ __('Department') }}
                                                  </th>
                                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                      {{ __('Position') }}
                                                  </th>
                                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                      {{ __('Actions') }}
                                                  </th>
                                              </tr>
                                          </thead>
                                          <tbody class="bg-white divide-y divide-gray-200">
                                              @foreach($company->employees as $employee)
                                                  <tr>
                                                      <td class="px-6 py-4 whitespace-nowrap">
                                                          <div class="text-sm font-medium text-gray-900">
                                                              {{ $employee->user->name }}
                                                          </div>
                                                      </td>
                                                      <td class="px-6 py-4 whitespace-nowrap">
                                                          <div class="text-sm text-gray-500">
                                                              {{ $employee->user->email }}
                                                          </div>
                                                      </td>
                                                      <td class="px-6 py-4 whitespace-nowrap">
                                                          <div class="text-sm text-gray-500">
                                                              {{ $employee->department ? $employee->department->name : 'N/A' }}
                                                          </div>
                                                      </td>
                                                      <td class="px-6 py-4 whitespace-nowrap">
                                                          <div class="text-sm text-gray-500">
                                                              {{ $employee->position ?: 'N/A' }}
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
                                  <p class="text-gray-500 text-sm">{{ __('No employees found.') }}</p>
                              @endif
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</x-app-layout>