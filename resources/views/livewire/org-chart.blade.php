<div>
  <div class="space-y-6">
      @forelse($departments as $department)
          <div class="border rounded-lg overflow-hidden">
              <div wire:click="toggleDepartment({{ $department->id }})"
                   class="bg-gray-100 px-4 py-3 flex justify-between items-center cursor-pointer">
                  <div class="flex items-center space-x-2">
                      <h3 class="text-lg font-medium text-gray-900">{{ $department->name }}</h3>
                      <span class="text-sm text-gray-500">({{ $department->company->name }})</span>
                  </div>
                  <svg class="h-5 w-5 text-gray-500 transform transition-transform duration-150 {{ $activeDepartment === $department->id ? 'rotate-180' : '' }}" viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                  </svg>
              </div>
              
              @if($activeDepartment === $department->id)
                  <div class="px-4 py-3">
                      <!-- Department Hierarchy -->
                      <div class="org-chart">
                          <ul class="org-chart__list">
                              @php
                                  $topEmployees = $this->getEmployeesByDepartment($department->id);
                              @endphp
                              
                              @forelse($topEmployees as $topEmployee)
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
              @endif
          </div>
      @empty
          <div class="text-center py-8">
              <p class="text-gray-500">{{ __('No departments found.') }}</p>
          </div>
      @endforelse
  </div>
</div>