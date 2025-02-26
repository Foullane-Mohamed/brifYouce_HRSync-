<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Admin Dashboard') }}
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <!-- Stats Overview -->
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
              <!-- Employees Card -->
              <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                  <div class="p-6">
                      <div class="flex items-center">
                          <div class="p-3 rounded-full bg-indigo-100 text-indigo-500">
                              <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                              </svg>
                          </div>
                          <div class="ml-5">
                              <div class="text-3xl font-semibold text-gray-800">{{ $stats['total_employees'] }}</div>
                              <div class="text-sm text-gray-500">{{ __('Employees') }}</div>
                          </div>
                      </div>
                      <div class="mt-6">
                          <a href="{{ route('employees.index') }}" class="inline-block text-sm text-indigo-600 font-medium hover:text-indigo-500">
                              {{ __('View all employees') }} →
                          </a>
                      </div>
                  </div>
              </div>

              <!-- Departments Card -->
              <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                  <div class="p-6">
                      <div class="flex items-center">
                          <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                              <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                              </svg>
                          </div>
                          <div class="ml-5">
                              <div class="text-3xl font-semibold text-gray-800">{{ $stats['total_departments'] }}</div>
                              <div class="text-sm text-gray-500">{{ __('Departments') }}</div>
                          </div>
                      </div>
                      <div class="mt-6">
                          <a href="{{ route('departments.index') }}" class="inline-block text-sm text-blue-600 font-medium hover:text-blue-500">
                              {{ __('View all departments') }} →
                          </a>
                      </div>
                  </div>
              </div>

              <!-- Active Contracts Card -->
              <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                  <div class="p-6">
                      <div class="flex items-center">
                          <div class="p-3 rounded-full bg-green-100 text-green-500">
                              <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                              </svg>
                          </div>
                          <div class="ml-5">
                              <div class="text-3xl font-semibold text-gray-800">{{ $stats['active_contracts'] }}</div>
                              <div class="text-sm text-gray-500">{{ __('Active Contracts') }}</div>
                          </div>
                      </div>
                      <div class="mt-6">
                          <a href="{{ route('contracts.index') }}" class="inline-block text-sm text-green-600 font-medium hover:text-green-500">
                              {{ __('View all contracts') }} →
                          </a>
                      </div>
                  </div>
              </div>
          </div>

          <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
              <!-- Recent Hires -->
              <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                  <div class="px-6 py-5 border-b border-gray-200">
                      <h3 class="text-lg font-medium text-gray-900">{{ __('Recent Hires') }}</h3>
                  </div>
                  <div class="p-6">
                      <div class="text-center">
                          <div class="text-3xl font-bold text-indigo-600">{{ $stats['recent_hires'] }}</div>
                          <div class="mt-2 text-sm text-gray-500">{{ __('Employees hired in the last 3 months') }}</div>
                      </div>
                  </div>
              </div>

              <!-- Expiring Contracts -->
              <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                  <div class="px-6 py-5 border-b border-gray-200">
                      <h3 class="text-lg font-medium text-gray-900">{{ __('Expiring Contracts') }}</h3>
                  </div>
                  <div class="p-6">
                      <div class="text-center">
                          <div class="text-3xl font-bold text-yellow-500">{{ $stats['expiring_contracts'] }}</div>
                          <div class="mt-2 text-sm text-gray-500">{{ __('Contracts expiring in the next month') }}</div>
                      </div>
                  </div>
              </div>
          </div>

          <!-- Organization Overview -->
          <div class="mt-6 bg-white overflow-hidden shadow-xl sm:rounded-lg">
              <div class="px-6 py-5 border-b border-gray-200">
                  <h3 class="text-lg font-medium text-gray-900">{{ __('Organization Overview') }}</h3>
              </div>
              <div class="p-6">
                  <div class="text-center mb-8">
                      <p class="text-gray-500">{{ __('View the organizational structure to understand reporting relationships and team hierarchies.') }}</p>
                  </div>
                  <div class="flex justify-center">
                      <a href="{{ route('org-chart.index') }}" class="inline-flex items-center px-5 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-300 disabled:opacity-25 transition">
                          {{ __('View Organization Chart') }}
                      </a>
                  </div>
              </div>
          </div>
      </div>
  </div>
</x-app-layout>