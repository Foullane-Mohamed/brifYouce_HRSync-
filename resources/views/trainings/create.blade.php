<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Create Training') }}
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
              <div class="p-6 bg-white border-b border-gray-200">
                  <form action="{{ route('trainings.store') }}" method="POST" enctype="multipart/form-data">
                      @csrf

                      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                          <div class="md:col-span-2">
                              <x-label for="name" value="{{ __('Training Name') }}" />
                              <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                              @error('name')
                                  <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                              @enderror
                          </div>

                          <div>
                              <x-label for="start_date" value="{{ __('Start Date') }}" />
                              <x-input id="start_date" class="block mt-1 w-full" type="date" name="start_date" :value="old('start_date')" />
                              @error('start_date')
                                  <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                              @enderror
                          </div>

                          <div>
                              <x-label for="end_date" value="{{ __('End Date') }}" />
                              <x-input id="end_date" class="block mt-1 w-full" type="date" name="end_date" :value="old('end_date')" />
                              @error('end_date')
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

                          <div class="md:col-span-2">
                              <x-label for="documents" value="{{ __('Training Documents (PDF, DOC, DOCX, PPT, PPTX)') }}" />
                              <input id="documents" type="file" name="documents[]" multiple class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" />
                              <p class="text-sm text-gray-500 mt-1">{{ __('You can select multiple files. Maximum size: 10MB per file.') }}</p>
                              @error('documents')
                                  <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                              @enderror
                              @error('documents.*')
                                  <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                              @enderror
                          </div>
                      </div>

                      <div class="flex items-center justify-end mt-4">
                          <a href="{{ route('trainings.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">{{ __('Cancel') }}</a>
                          <x-button>
                              {{ __('Create Training') }}
                          </x-button>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>

  <script>
      document.addEventListener('DOMContentLoaded', function() {
          const startDateInput = document.getElementById('start_date');
          const endDateInput = document.getElementById('end_date');
          
          // Ensure end date is after start date
          startDateInput.addEventListener('change', function() {
              if (endDateInput.value && startDateInput.value > endDateInput.value) {
                  endDateInput.value = startDateInput.value;
              }
          });
          
          endDateInput.addEventListener('change', function() {
              if (startDateInput.value && endDateInput.value < startDateInput.value) {
                  alert('End date cannot be before start date');
                  endDateInput.value = startDateInput.value;
              }
          });
      });
  </script>
</x-app-layout>