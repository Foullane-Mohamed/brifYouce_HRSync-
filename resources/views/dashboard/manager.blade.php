<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Manager Dashboard') }}
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <!-- Stats Overview -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
              <!-- Team Size Card -->
              <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                  <div class="p-6">
                      <div class="flex items-center">
                          <div class="p-3 rounded-full bg-indigo-100 text-indigo-500">
                              <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                              </svg>
                          </div>
                          <div class="ml-5">
                              <div class="text-3xl font-semibold text-gray-800">{{ $stats['team_size'] }}</div>
                              <div class="text-sm text-gray-500">{{ __('Team Members') }}</div>
                          </div>
                      </div>
                  </div>
              </div>

              <!-- Department Size Card -->
              <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                  <div class="p-6">
                      <div class="flex items-center">
                          <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                              <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                              </svg>
                          </div>
                          <div class="ml-5">
                              <div class="text-3xl font-semibold text-gray-800">{{ $stats['department_size'] }}</div>
                              <div class="text-sm text-gray-500">{{ __('Department Size') }}</div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Active Contracts -->
              <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                  <div class="px-6 py-5 border-b border-gray-200">
                      <h3 class="text-lg font-medium text-gray-900">{{ __('Team Contracts') }}</h3>
                  </div>
                  <div class="p-6">
                      <div class="text-center">
                          <div class="text-3xl font-bold text-green-600">{{ $stats['active_team_contracts'] }}</div>
                          <div class="mt-2 text-sm text-gray-500">{{ __('Active contracts for your team members') }}</div>
                      </div>
                      <div class="mt-6 text-center">
                          <a href="{{ route('contracts.index') }}" class="inline-block text-sm text-indigo-600 font-medium hover:text-indigo-500">
                              {{ __('View contracts') }} →
                          </a>
                      </div>
                  </div>
              </div>

              <!-- Team Trainings -->
              <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                  <div class="px-6 py-5 border-b border-gray-200">
                      <h3 class="text-lg font-medium text-gray-900">{{ __('Team Trainings') }}</h3>
                  </div>
                  <div class="p-6">
                      <div class="text-center">
                          <div class="text-3xl font-bold text-blue-600">{{ $stats['team_trainings'] }}</div>
                          <div class="mt-2 text-sm text-gray-500">{{ __('Ongoing trainings for your team') }}</div>
                      </div>
                      <div class="mt-6 text-center">
                          <a href="{{ route('trainings.index') }}" class="inline-block text-sm text-indigo-600 font-medium hover:text-indigo-500">
                              {{ __('View trainings') }} →
                          </a>
                      </div>
                  </div>
              </div>
          </div>

          <!-- Team Members -->
          <div class="mt-6 bg-white overflow-hidden shadow-xl sm:rounded-lg">
              <div class="px-6 py-5 border-b border-gray-200">
                  <h3 class="text-lg font-medium text-gray-900">{{ __('Your Team') }}</h3>
              </div>
              <div class="p-6">
                  @if(Auth::user()->employee->subordinates->count() > 0)
                      <div class="overflow-x-auto">
                          <table class="min-w-full divide-y divide-gray-200">
                              <thead class="bg-gray-50">
                                  <tr>
                                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                          {{ __('Employee') }}
                                      </th>
                                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                          {{ __('Position') }}
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
                                  @foreach(Auth::user()->employee->subordinates as $subordinate)
                                      <tr>
                                          <td class="px-6 py-4 whitespace-nowrap">
                                              <div class="flex items-center">
                                                  <div class="flex-shrink-0 h-10 w-10">
                                                      @if($subordinate->user->profile_photo_url)
                                                          <img class="h-10 w-10 rounded-full" src="{{ $subordinate->user->profile_photo_url }}" alt="{{ $subordinate->user->name }}">
                                                      @else
                                                          <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                              <span class="text-gray-500">{{ substr($subordinate->user->name, 0, 1) }}</span>
                                                          </div>
                                                      @endif
                                                  </div>
                                                  <div class="ml-4">
                                                      <div class="text-sm font-medium text-gray-900">
                                                          {{ $subordinate->user->name }}
                                                      </div>
                                                      <div class="text-sm text-gray-500">
                                                          {{ $subordinate->user->email }}
                                                      </div>
                                                  </div>
                                              </div>
                                          </td>
                                          <td class="px-6 py-4 whitespace-nowrap">
                                              <div class="text-sm text-gray-900">{{ $subordinate->position ?: 'N/A' }}</div>
                                          </td>
                                          <td class="px-6 py-4 whitespace-nowrap">
                                              <div class="text-sm text-gray-500">
                                                  {{ $subordinate->hire_date ? $subordinate->hire_date->format('M d, Y') : 'N/A' }}
                                              </div>
                                          </td>
                                          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                              <a href="{{ route('employees.show', $subordinate) }}" class="text-indigo-600 hover:text-indigo-900">{{ __('View') }}</a>
                                          </td>
                                      </tr>
                                  @endforeach
                              </tbody>
                          </table>
                      </div>
                  @else
                      <div class="text-center py-4">
                          <p class="text-gray-500">{{ __('You have no team members assigned to you.') }}</p>
                      </div>
                  @endif
              </div>
          </div>
      </div>
  </div>
</x-app-layout>