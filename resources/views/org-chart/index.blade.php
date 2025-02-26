<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Organization Chart') }}
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
              <div class="p-6 bg-white border-b border-gray-200">
                  <div x-data="{ activeDepartment: null }" class="space-y-6">
                      @forelse($departments as $department)
                          <div class="border rounded-lg overflow-hidden">
                              <div @click="activeDepartment = activeDepartment === {{ $department->id }} ? null : {{ $department->id }}"
                                   class="bg-gray-100 px-4 py-3 flex justify-between items-center cursor-pointer">
                                  <div class="flex items-center space-x-2">
                                      <h3 class="text-lg font-medium text-gray-900">{{ $department->name }}</h3>
                                      <span class="text-sm text-gray-500">({{ $department->company->name }})</span>
                                  </div>
                                  <svg :class="{'rotate-180': activeDepartment === {{ $department->id }}}" class="h-5 w-5 text-gray-500 transform transition-transform duration-150" viewBox="0 0 20 20" fill="currentColor">
                                      <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                  </svg>
                              </div>
                              <div x-show="activeDepartment === {{ $department->id }}" x-cloak class="px-4 py-3">
                                  <!-- Department Hierarchy -->
                                  <div class="org-chart">
                                      <ul class="org-chart__list">
                                          @forelse($department->employees->whereNull('manager_id') as $topEmployee)
                                              <li class="org-chart__item">
                                                  <div class="org-chart__card bg-indigo-50 hover:bg-indigo-100 border-indigo-200">
                                                      <div class="flex items-center">
                                                          <div class="flex-shrink-0 h-10 w-10">
                                                              @if($topEmployee->user->profile_photo_url)
                                                                  <img class="h-10 w-10 rounded-full" src="{{ $topEmployee->user->profile_photo_url }}" alt="{{ $topEmployee->user->name }}">
                                                              @else
                                                                  <div class="h-10 w-10 rounded-full bg-indigo-200 flex items-center justify-center">
                                                                      <span class="text-indigo-500">{{ substr($topEmployee->user->name, 0, 1) }}</span>
                                                                  </div>
                                                              @endif
                                                          </div>
                                                          <div class="ml-4">
                                                              <a href="{{ route('employees.show', $topEmployee) }}" class="text-sm font-medium text-gray-900 hover:text-indigo-600">
                                                                  {{ $topEmployee->user->name }}
                                                              </a>
                                                              <p class="text-xs text-gray-500">{{ $topEmployee->position }}</p>
                                                          </div>
                                                      </div>
                                                  </div>
                                                  
                                                  @if($topEmployee->subordinates->count() > 0)
                                                      <ul class="org-chart__list">
                                                          @foreach($topEmployee->subordinates as $middleEmployee)
                                                              <li class="org-chart__item">
                                                                  <div class="org-chart__card bg-blue-50 hover:bg-blue-100 border-blue-200">
                                                                      <div class="flex items-center">
                                                                          <div class="flex-shrink-0 h-10 w-10">
                                                                              @if($middleEmployee->user->profile_photo_url)
                                                                                  <img class="h-10 w-10 rounded-full" src="{{ $middleEmployee->user->profile_photo_url }}" alt="{{ $middleEmployee->user->name }}">
                                                                              @else
                                                                                  <div class="h-10 w-10 rounded-full bg-blue-200 flex items-center justify-center">
                                                                                      <span class="text-blue-500">{{ substr($middleEmployee->user->name, 0, 1) }}</span>
                                                                                  </div>
                                                                              @endif
                                                                          </div>
                                                                          <div class="ml-4">
                                                                              <a href="{{ route('employees.show', $middleEmployee) }}" class="text-sm font-medium text-gray-900 hover:text-blue-600">
                                                                                  {{ $middleEmployee->user->name }}
                                                                              </a>
                                                                              <p class="text-xs text-gray-500">{{ $middleEmployee->position }}</p>
                                                                          </div>
                                                                      </div>
                                                                  </div>
                                                                  
                                                                  @if($middleEmployee->subordinates->count() > 0)
                                                                      <ul class="org-chart__list">
                                                                          @foreach($middleEmployee->subordinates as $employee)
                                                                              <li class="org-chart__item">
                                                                                  <div class="org-chart__card bg-gray-50 hover:bg-gray-100 border-gray-200">
                                                                                      <div class="flex items-center">
                                                                                          <div class="flex-shrink-0 h-10 w-10">
                                                                                              @if($employee->user->profile_photo_url)
                                                                                                  <img class="h-10 w-10 rounded-full" src="{{ $employee->user->profile_photo_url }}" alt="{{ $employee->user->name }}">
                                                                                              @else
                                                                                                  <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                                                                      <span class="text-gray-500">{{ substr($employee->user->name, 0, 1) }}</span>
                                                                                                  </div>
                                                                                              @endif
                                                                                          </div>
                                                                                          <div class="ml-4">
                                                                                              <a href="{{ route('employees.show', $employee) }}" class="text-sm font-medium text-gray-900 hover:text-gray-600">
                                                                                                  {{ $employee->user->name }}
                                                                                              </a>
                                                                                              <p class="text-xs text-gray-500">{{ $employee->position }}</p>
                                                                                          </div>
                                                                                      </div>
                                                                                  </div>
                                                                              </li>
                                                                          @endforeach
                                                                      </ul>
                                                                  @endif
                                                              </li>
                                                          @endforeach
                                                      </ul>
                                                  @endif
                                              </li>
                                          @empty
                                              <li class="py-2 px-4 text-gray-500 text-sm">{{ __('No employees found in this department.') }}</li>
                                          @endforelse
                                      </ul>
                                  </div>
                              </div>
                          </div>
                      @empty
                          <div class="text-center py-8">
                              <p class="text-gray-500">{{ __('No departments found.') }}</p>
                          </div>
                      @endforelse
                  </div>
              </div>
          </div>
      </div>
  </div>

  <style>
      [x-cloak] { display: none !important; }
      
      .org-chart {
          overflow-x: auto;
          padding: 20px 0;
      }
      
      .org-chart__list {
          display: flex;
          justify-content: center;
          list-style: none;
          padding: 0;
          margin: 0;
      }
      
      .org-chart__item {
          flex: 1;
          display: flex;
          flex-direction: column;
          align-items: center;
          max-width: 300px;
          margin: 0 10px;
          position: relative;
      }
      
      .org-chart__item::before {
          content: '';
          position: absolute;
          top: 0;
          left: 50%;
          width: 1px;
          height: 20px;
          background-color: #ddd;
      }
      
      .org-chart__item:first-child:last-child::before {
          display: none;
      }
      
      .org-chart__card {
          border: 1px solid;
          border-radius: 0.5rem;
          padding: 1rem;
          margin-bottom: 20px;
          width: 100%;
          position: relative;
          transition: all 0.2s ease;
      }
      
      .org-chart__list .org-chart__list {
          position: relative;
          margin-top: 20px;
      }
      
      .org-chart__list .org-chart__list::before {
          content: '';
          position: absolute;
          top: -20px;
          left: 50%;
          width: 1px;
          height: 20px;
          background-color: #ddd;
      }
      
      .org-chart__list .org-chart__list .org-chart__item::before {
          height: 20px;
          top: -20px;
      }
      
      .org-chart__list .org-chart__list .org-chart__item:not(:only-child)::after {
          content: '';
          position: absolute;
          top: -20px;
          width: 100%;
          height: 1px;
          background-color: #ddd;
      }
  </style>
</x-app-layout>