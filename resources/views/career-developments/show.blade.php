<x-app-layout>
  <x-slot name="header">
      <div class="flex justify-between items-center">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              {{ __('Career Development Details') }}
          </h2>
          <div class="flex space-x-2">
              @can('update', $careerDevelopment)
                  <a href="{{ route('career-developments.edit', $careerDevelopment) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-500 active:bg-yellow-700 focus:outline-none focus:border-yellow-700 focus:ring focus:ring-yellow-300 disabled:opacity-25 transition">
                      {{ __('Edit') }}
                  </a>
              @endcan
              <a href="{{ route('career-developments.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
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
                          <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Development Information') }}</h3>
                          <div class="space-y-4">
                              <div>
                                  <span class="text-sm text-gray-500">{{ __('Development Type') }}</span>
                                  <p class="text-gray-800">
                                      <span class="mt-1 px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                          @if($careerDevelopment->type == 'Promotion') bg-green-100 text-green-800 
                                          @elseif($careerDevelopment->type == 'Salary Increase') bg-blue-100 text-blue-800 
                                          @elseif($careerDevelopment->type == 'Position Change') bg-purple-100 text-purple-800 
                                          @else bg-gray-100 text-gray-800 @endif">
                                          {{ $careerDevelopment->type }}
                                      </span>
                                  </p>
                              </div>
                              <div>
                                  <span class="text-sm text-gray-500">{{ __('Date') }}</span>
                                  <p class="text-gray-800 font-medium">{{ $careerDevelopment->date->format('M d, Y') }}</p>
                              </div>
                              <div>
                                  <span class="text-sm text-gray-500">{{ __('Previous Value') }}</span>
                                  <p class="text-gray-800">{{ $careerDevelopment->previous_value ?: 'N/A' }}</p>
                              </div>
                              <div>
                                  <span class="text-sm text-gray-500">{{ __('New Value') }}</span>
                                  <p class="text-gray-800">{{ $careerDevelopment->new_value ?: 'N/A' }}</p>
                              </div>
                              <div>
                                  <span class="text-sm text-gray-500">{{ __('Description') }}</span>
                                  <p class="text-gray-800 mt-1">
                                      {!! nl2br(e($careerDevelopment->description)) ?: '<span class="text-gray-500 italic">No description provided</span>' !!}
                                  </p>
                              </div>
                          </div>
                      </div>
                      
                      <div class="md:col-span-2">
                          <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Employee Information') }}</h3>
                          <div class="flex items-center mb-6">
                              <div class="flex-shrink-0 h-14 w-14">
                                  @if($careerDevelopment->employee->user->profile_photo_url)
                                      <img class="h-14 w-14 rounded-full object-cover" src="{{ $careerDevelopment->employee->user->profile_photo_url }}" alt="{{ $careerDevelopment->employee->user->name }}">
                                  @else
                                      <div class="h-14 w-14 rounded-full bg-gray-200 flex items-center justify-center">
                                          <span class="text-gray-500 text-xl">{{ substr($careerDevelopment->employee->user->name, 0, 1) }}</span>
                                      </div>
                                  @endif
                              </div>
                              <div class="ml-4">
                                  <h4 class="text-lg font-semibold text-gray-900">
                                      <a href="{{ route('employees.show', $careerDevelopment->employee) }}" class="hover:text-indigo-600">
                                          {{ $careerDevelopment->employee->user->name }}
                                      </a>
                                  </h4>
                                  <div class="text-sm text-gray-600">{{ $careerDevelopment->employee->position ?: 'No position' }}</div>
                                  <div class="text-sm text-gray-600">{{ $careerDevelopment->employee->department ? $careerDevelopment->employee->department->name : 'No department' }}</div>
                              </div>
                          </div>
                          
                          <div class="mt-8">
                              <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Career Timeline') }}</h3>
                              <div class="relative pl-8 border-l-2 border-gray-200">
                                  @foreach($careerDevelopment->employee->careerDevelopments()->orderBy('date', 'desc')->get() as $development)
                                      <div class="mb-8 relative">
                                          <!-- Timeline dot -->
                                          <div class="absolute w-4 h-4 rounded-full bg-{{ $development->id === $careerDevelopment->id ? 'indigo' : 'gray' }}-500 -left-[10px] top-1 border-2 border-white"></div>
                                          
                                          <div class="ml-2 pb-4 {{ $development->id === $careerDevelopment->id ? 'bg-indigo-50 rounded-lg p-4 shadow-sm border border-indigo-100' : '' }}">
                                              <div class="flex justify-between items-center mb-2">
                                                  <span class="px-2 py-1 text-xs leading-5 font-semibold rounded-full 
                                                      @if($development->type == 'Promotion') bg-green-100 text-green-800 
                                                      @elseif($development->type == 'Salary Increase') bg-blue-100 text-blue-800 
                                                      @elseif($development->type == 'Position Change') bg-purple-100 text-purple-800 
                                                      @else bg-gray-100 text-gray-800 @endif">
                                                      {{ $development->type }}
                                                  </span>
                                                  <span class="text-sm text-gray-500">{{ $development->date->format('M d, Y') }}</span>
                                              </div>
                                              
                                              @if($development->previous_value || $development->new_value)
                                                  <div class="flex space-x-2 mb-2">
                                                      @if($development->previous_value)
                                                          <div class="text-sm bg-gray-100 px-2 py-1 rounded">
                                                              <span class="text-gray-600">From:</span> {{ $development->previous_value }}
                                                          </div>
                                                      @endif
                                                      @if($development->new_value)
                                                          <div class="text-sm bg-green-50 px-2 py-1 rounded">
                                                              <span class="text-gray-600">To:</span> {{ $development->new_value }}
                                                          </div>
                                                      @endif
                                                  </div>
                                              @endif
                                              
                                              @if($development->description)
                                                  <div class="text-sm text-gray-600 mt-1">
                                                      {{ $development->description }}
                                                  </div>
                                              @endif
                                              
                                              @if($development->id !== $careerDevelopment->id)
                                                  <div class="mt-2">
                                                      <a href="{{ route('career-developments.show', $development) }}" class="text-xs text-indigo-600 hover:text-indigo-900">View details</a>
                                                  </div>
                                              @endif
                                          </div>
                                      </div>
                                  @endforeach
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</x-app-layout>