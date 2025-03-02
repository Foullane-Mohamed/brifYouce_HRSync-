<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Create Career Development') }}
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
              <div class="p-6 bg-white border-b border-gray-200">
                  <form action="{{ route('career-developments.store') }}" method="POST">
                      @csrf

                      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                          <div>
                              <x-label for="employee_id" value="{{ __('Employee') }}" />
                              <x-select id="employee_id" class="block mt-1 w-full" name="employee_id" required>
                                  <option value="">{{ __('Select Employee') }}</option>
                                  @foreach($employees as $employee)
                                      <option value="{{ $employee->id }}" {{ old('employee_id', request('employee_id')) == $employee->id ? 'selected' : '' }}>
                                          {{ $employee->user->name }} ({{ $employee->position ?: 'No position' }})
                                      </option>
                                  @endforeach
                              </x-select>
                              @error('employee_id')
                                  <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                              @enderror
                          </div>

                          <div>
                              <x-label for="type" value="{{ __('Development Type') }}" />
                              <x-select id="type" class="block mt-1 w-full" name="type" required>
                                  <option value="">{{ __('Select Type') }}</option>
                                  <option value="Promotion" {{ old('type') == 'Promotion' ? 'selected' : '' }}>{{ __('Promotion') }}</option>
                                  <option value="Salary Increase" {{ old('type') == 'Salary Increase' ? 'selected' : '' }}>{{ __('Salary Increase') }}</option>
                                  <option value="Training" {{ old('type') == 'Training' ? 'selected' : '' }}>{{ __('Training') }}</option>
                                  <option value="Position Change" {{ old('type') == 'Position Change' ? 'selected' : '' }}>{{ __('Position Change') }}</option>
                              </x-select>
                              @error('type')
                                  <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                              @enderror
                          </div>

                          <div>
                              <x-label for="previous_value" value="{{ __('Previous Value') }}" />
                              <x-input id="previous_value" class="block mt-1 w-full" type="text" name="previous_value" :value="old('previous_value')" />
                              <p class="text-xs text-gray-500 mt-1">{{ __('E.g., previous position, previous salary, etc.') }}</p>
                              @error('previous_value')
                                  <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                              @enderror
                          </div>

                          <div>
                              <x-label for="new_value" value="{{ __('New Value') }}" />
                              <x-input id="new_value" class="block mt-1 w-full" type="text" name="new_value" :value="old('new_value')" />
                              <p class="text-xs text-gray-500 mt-1">{{ __('E.g., new position, new salary, etc.') }}</p>
                              @error('new_value')
                                  <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                              @enderror
                          </div>

                          <div>
                              <x-label for="date" value="{{ __('Date') }}" />
                              <x-input id="date" class="block mt-1 w-full" type="date" name="date" :value="old('date', date('Y-m-d'))" required />
                              @error('date')
                                  <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                              @enderror
                          </div>

                          <div class="md:col-span-2">
                              <x-label for="description" value="{{ __('Description') }}" />
                              <x-textarea id="description" class="block mt-1 w-full" name="description">{{ old('description') }}</x-textarea>
                              @error('description')
                                  <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                              @enderror
                          </div>
                      </div>

                      <div class="flex items-center justify-end mt-4">
                          <a href="{{ route('career-developments.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">{{ __('Cancel') }}</a>
                          <x-button>
                              {{ __('Create Development Record') }}
                          </x-button>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>

  <script>
      document.addEventListener('DOMContentLoaded', function() {
          const typeSelect = document.getElementById('type');
          const previousValueInput = document.getElementById('previous_value');
          const newValueInput = document.getElementById('new_value');
          const employeeSelect = document.getElementById('employee_id');

          // When type changes, update placeholder text
          typeSelect.addEventListener('change', updatePlaceholders);
          
          // Also update when employee changes
          employeeSelect.addEventListener('change', function() {
              if (typeSelect.value) {
                  updatePlaceholders();
              }
          });
          
          function updatePlaceholders() {
              const selectedType = typeSelect.value;
              const selectedEmployeeId = employeeSelect.value;
              
              if (selectedType === 'Salary Increase') {
                  previousValueInput.placeholder = 'Previous salary amount';
                  newValueInput.placeholder = 'New salary amount';
              } else if (selectedType === 'Promotion' || selectedType === 'Position Change') {
                  previousValueInput.placeholder = 'Previous position';
                  newValueInput.placeholder = 'New position';
              } else if (selectedType === 'Training') {
                  previousValueInput.placeholder = 'Previous qualification';
                  newValueInput.placeholder = 'New qualification/training completed';
              } else {
                  previousValueInput.placeholder = '';
                  newValueInput.placeholder = '';
              }
          }
          
          // Initialize placeholders based on initial values
          if (typeSelect.value) {
              updatePlaceholders();
          }
      });
  </script>
</x-app-layout>