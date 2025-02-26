<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Edit Company') }}
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
              <div class="p-6 bg-white border-b border-gray-200">
                  <form action="{{ route('companies.update', $company) }}" method="POST" enctype="multipart/form-data">
                      @csrf
                      @method('PUT')

                      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                          <div>
                              <x-label for="name" value="{{ __('Company Name') }}" />
                              <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $company->name)" required autofocus />
                              @error('name')
                                  <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                              @enderror
                          </div>

                          <div>
                              <x-label for="email" value="{{ __('Email') }}" />
                              <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $company->email)" required />
                              @error('email')
                                  <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                              @enderror
                          </div>

                          <div>
                              <x-label for="phone" value="{{ __('Phone') }}" />
                              <x-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone', $company->phone)" />
                              @error('phone')
                                  <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                              @enderror
                          </div>

                          <div>
                              <x-label for="logo" value="{{ __('Logo') }}" />
                              @if($company->getFirstMediaUrl('logos'))
                                  <div class="mt-1 mb-2">
                                      <img src="{{ $company->getFirstMediaUrl('logos') }}" alt="{{ $company->name }}" class="h-20 w-20 object-cover rounded">
                                  </div>
                              @endif
                              <input id="logo" type="file" name="logo" class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" />
                              @error('logo')
                                  <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                              @enderror
                          </div>

                          <div class="md:col-span-2">
                              <x-label for="address" value="{{ __('Address') }}" />
                              <x-textarea id="address" class="block mt-1 w-full" name="address">{{ old('address', $company->address) }}</x-textarea>
                              @error('address')
                                  <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                              @enderror
                          </div>
                      </div>

                      <div class="flex items-center justify-end mt-4">
                          <a href="{{ route('companies.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">{{ __('Cancel') }}</a>
                          <x-button>
                              {{ __('Update Company') }}
                          </x-button>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>
</x-app-layout>
