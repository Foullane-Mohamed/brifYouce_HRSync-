<x-app-layout>
  <x-slot name="header">
      <div class="flex justify-between items-center">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              {{ __('Contract Details') }}
          </h2>
          <div class="flex space-x-2">
              @can('update', $contract)
                  <a href="{{ route('contracts.edit', $contract) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-500 active:bg-yellow-700 focus:outline-none focus:border-yellow-700 focus:ring focus:ring-yellow-300 disabled:opacity-25 transition">
                      {{ __('Edit') }}
                  </a>
              @endcan
              <a href="{{ route('contracts.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                  {{ __('Back') }}
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
                          <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Contract Information') }}</h3>
                          <div class="space-y-4">
                              <div>
                                  <span class="text-sm text-gray-500">{{ __('Contract Type') }}</span>
                                  <p class="text-gray-800 font-medium">{{ $contract->type }}</p>
                              </div>
                              <div>
                                  <span class="text-sm text-gray-500">{{ __('Status') }}</span>
                                  <p class="text-gray-800">
                                      <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $contract->end_date && $contract->end_date < now() ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                          {{ $contract->end_date && $contract->end_date < now() ? 'Expired' : 'Active' }}
                                      </span>
                                  </p>
                              </div>
                              <div>
                                  <span class="text-sm text-gray-500">{{ __('Start Date') }}</span>
                                  <p class="text-gray-800">{{ $contract->start_date->format('M d, Y') }}</p>
                              </div>
                              <div>
                                  <span class="text-sm text-gray-500">{{ __('End Date') }}</span>
                                  <p class="text-gray-800">{{ $contract->end_date ? $contract->end_date->format('M d, Y') : 'Indefinite' }}</p>
                              </div>
                              <div>
                                  <span class="text-sm text-gray-500">{{ __('Duration') }}</span>
                                  <p class="text-gray-800">
                                      @if($contract->end_date)
                                          {{ $contract->start_date->diffInMonths($contract->end_date) }} months
                                      @else
                                          Indefinite
                                      @endif
                                  </p>
                              </div>
                          </div>
                      </div>
                      
                      <div class="md:col-span-2">
                          <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Employee Information') }}</h3>
                          <div class="flex items-center mb-6">
                              <div class="flex-shrink-0 h-14 w-14">
                                  @if($contract->employee->user->profile_photo_url)
                                      <img class="h-14 w-14 rounded-full object-cover" src="{{ $contract->employee->user->profile_photo_url }}" alt="{{ $contract->employee->user->name }}">
                                  @else
                                      <div class="h-14 w-14 rounded-full bg-gray-200 flex items-center justify-center">
                                          <span class="text-gray-500 text-xl">{{ substr($contract->employee->user->name, 0, 1) }}</span>
                                      </div>
                                  @endif
                              </div>
                              <div class="ml-4">
                                  <h4 class="text-lg font-semibold text-gray-900">{{ $contract->employee->user->name }}</h4>
                                  <div class="text-sm text-gray-600">{{ $contract->employee->position ?: 'No position' }}</div>
                                  <div class="text-sm text-gray-600">{{ $contract->employee->department ? $contract->employee->department->name : 'No department' }}</div>
                              </div>
                          </div>
                          
                          <div class="mt-8">
                              <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Contract Details') }}</h3>
                              <div class="bg-gray-50 p-4 rounded-md text-gray-700">
                                  {!! nl2br(e($contract->details)) ?: '<em class="text-gray-500">No details provided</em>' !!}
                              </div>
                          </div>
                          
                          @if($contract->getFirstMedia('contracts'))
                              <div class="mt-8">
                                  <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Contract Document') }}</h3>
                                  <a href="{{ $contract->getFirstMediaUrl('contracts') }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-300 disabled:opacity-25 transition">
                                      <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                      </svg>
                                      {{ __('Download Document') }}
                                  </a>
                              </div>
                          @endif
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</x-app-layout>