<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Create Contract') }}
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
              <div class="p-6 bg-white border-b border-gray-200">
                  <form action="{{ route('contracts.store') }}" method="POST" enctype="multipart/form-data">
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
                              <x-label for="type" value="{{ __('Contract Type') }}" />
                              <x-select id="type" class="block mt-1 w-full" name="type" required>
                                  <option value="">{{ __('Select Type') }}</option>
                                  <option value="CDI" {{ old('type') == 'CDI' ? 'selected' : '' }}>{{ __('CDI (Permanent)') }}</option>
                                  <option value="CDD" {{ old('type') == 'CDD' ? 'selected' : '' }}>{{ __('CDD (Fixed term)') }}</option>
                                  <option value="Internship" {{ old('type') == 'Internship' ? 'selected' : '' }}>{{ __('Internship') }}</option>
                                  <option value="Freelance" {{ old('type') == 'Freelance' ? 'selected' : '' }}>{{ __('Freelance') }}</option>
                              </x-select>
                              @error('type')
                                  <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                              @enderror
                          </div>

                          <div>
                              <x-label for="start_date" value="{{ __('Start Date') }}" />
                              <x-input id="start_date" class="block mt-1 w-full" type="date" name="start_date" :value="old('start_date')" required />
                              @error('start_date')
                                  <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                              @enderror
                          </div>

                          <div>
                              <x-label for="end_date" value="{{ __('End Date (leave empty for indefinite contracts)') }}" />
                              <x-input id="end_date" class="block mt-1 w-full" type="date" name="end_date" :value="old('end_date')" />
                              @error('end_date')
                                  <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                              @enderror
                          </div>

                          <div class="md:col-span-2">
                              <x-label for="details" value="{{ __('Contract Details') }}" />
                              <x-textarea id="details" class="block mt-1 w-full" name="details">{{ old('details') }}</x-textarea>
                              @error('details')
                                  <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                              @enderror
                          </div>

                          <div class="md:col-span-2">
                              <x-label for="document" value="{{ __('Contract Document (PDF, DOC, DOCX)') }}" />
                              <input id="document" type="file" name="document" class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" />
                              @error('document')
                                  <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                              @enderror
                          </div>
                      </div>

                      <div class="flex items-center justify-end mt-4">
                          <a href="{{ route('contracts.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">{{ __('Cancel') }}</a>
                          <x-button>
                              {{ __('Create Contract') }}
                          </x-button>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>
</x-app-layout>