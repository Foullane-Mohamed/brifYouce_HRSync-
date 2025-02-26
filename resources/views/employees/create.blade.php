<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Create Employee') }}
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
              <div class="p-6 bg-white border-b border-gray-200">
                  <form action="{{ route('employees.store') }}" method="POST">
                      @csrf

                      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                          <h3 class="text-lg font-medium text-gray-900 md:col-span-2">{{ __('User Account Information') }}</h3>
                          
                          <div>
                              <x-label for="user[name]" value="{{ __('Name') }}" />
                              <x-input id="user[name]" class="block mt-1 w-full" type="text" name="user[name]" :value="old('user.name')" required autofocus />
                              @error('user.name')
                                  <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                              @enderror
                          </div>

                          <div>
                              <x-label for="user[email]" value="{{ __('Email') }}" />
                              <x-input id="user[email]" class="block mt-1 w-full" type="email" name="user[email]" :value="old('user.email')" required />
                              @error('user.email')
                                  <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                              @enderror
                          </div>

                          <div>
                              <x-label for="user[password]" value="{{ __('Password') }}" />
                              <x-input id="user[password]" class="block mt-1 w-full" type="password" name="user[password]" required autocomplete="new-password" />
                              @error('user.password')
                                  <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                              @enderror
                          </div>

                          <div>
                              <x-label for="user[password_confirmation]" value="{{ __('Confirm Password') }}" />
                              <x-input id="user[password_confirmation]" class="block mt-1 w-full" type="password" name="user[password_confirmation]" required autocomplete="new-password" />
                          </div>

                          <div>
                              <x-label for="user[phone]" value="{{ __('Phone') }}" />
                              <x-input id="user[phone]" class="block mt-1 w-full" type="text" name="user[phone]" :value="old('user.phone')" />
                              @error('user.phone')
                                  <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                              @enderror
                          </div>

                          <div>
                              <x-label for="user[company_id]" value="{{ __('Company') }}" />
                              <x-select id="user[company_id]" class="block mt-1 w-full" name="user[company_id]" required>
                                  <option value="">{{ __('Select Company') }}</option>
                                  @foreach(\App\Models\Company::all() as $company)
                                      <option value="{{ $company->id }}" {{ old('user.company_id') == $company->id ? 'selected' : '' }}>
                                          {{ $company->name }}
                                      </option>
                                  @endforeach
                              </x-select>
                              @error('user.company_id')
                                  <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                              @enderror
                          </div>

                          <h3 class="text-lg font-medium text-gray-900 md:col-span-2 mt-4">{{ __('Employee Information') }}</h3>

                          <div>
                              <x-label for="employee[department_id]" value="{{ __('Department') }}" />
                              <x-select id="employee[department_id]" class="block mt-1 w-full" name="employee[department_id]">
                                  <option value="">{{ __('Select Department') }}</option>
                                  @foreach($departments as $department)
                                      <option value="{{ $department->id }}" {{ old('employee.department_id') == $department->id ? 'selected' : '' }}>
                                          {{ $department->name }} ({{ $department->company->name }})
                                      </option>
                                  @endforeach
                              </x-select>
                              @error('employee.department_id')
                                  <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                              @enderror
                          </div>

                          <div>
                              <x-label for="employee[manager_id]" value="{{ __('Manager') }}" />
                              <x-select id="employee[manager_id]" class="block mt-1 w-full" name="employee[manager_id]">
                                  <option value="">{{ __('Select Manager') }}</option>
                                  @foreach($managers as $manager)
                                      <option value="{{ $manager->id }}" {{ old('employee.manager_id') == $manager->id ? 'selected' : '' }}>
                                          {{ $manager->user->name }} ({{ $manager->department->name ?? 'No Department' }})
                                      </option>
                                  @endforeach
                              </x-select>
                              @error('employee.manager_id')
                                  <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                              @enderror
                          </div>

                          <div>
                              <x-label for="employee[position]" value="{{ __('Position') }}" />
                              <x-input id="employee[position]" class="block mt-1 w-full" type="text" name="employee[position]" :value="old('employee.position')" />
                              @error('employee.position')
                                  <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                              @enderror
                          </div>

                          <div>
                              <x-label for="employee[salary]" value="{{ __('Salary') }}" />
                              <x-input id="employee[salary]" class="block mt-1 w-full" type="number" name="employee[salary]" step="0.01" min="0" :value="old('employee.salary')" />
                              @error('employee.salary')
                                  <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                              @enderror
                          </div>

                          <div>
                              <x-label for="employee[hire_date]" value="{{ __('Hire Date') }}" />
                              <x-input id="employee[hire_date]" class="block mt-1 w-full" type="date" name="employee[hire_date]" :value="old('employee.hire_date')" />
                              @error('employee.hire_date')
                                  <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                              @enderror
                          </div>

                          <div>
                              <x-label for="employee[birth_date]" value="{{ __('Birth Date') }}" />
                              <x-input id="employee[birth_date]" class="block mt-1 w-full" type="date" name="employee[birth_date]" :value="old('employee.birth_date')" />
                              @error('employee.birth_date')
                                  <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                              @enderror
                          </div>

                          <div class="md:col-span-2">
                              <x-label for="employee[address]" value="{{ __('Address') }}" />
                              <x-textarea id="employee[address]" class="block mt-1 w-full" name="employee[address]">{{ old('employee.address') }}</x-textarea>
                              @error('employee.address')
                                  <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                              @enderror
                          </div>

                          <div class="md:col-span-2">
                              <x-label for="role" value="{{ __('Role') }}" />
                              <x-select id="role" class="block mt-1 w-full" name="role" required>
                                  <option value="">{{ __('Select Role') }}</option>
                                  @foreach(\Spatie\Permission\Models\Role::whereNotIn('name', ['admin'])->get() as $role)
                                      <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                                          {{ ucfirst($role->name) }}
                                      </option>
                                  @endforeach
                              </x-select>
                              @error('role')
                                  <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                              @enderror
                          </div>
                      </div>

                      <div class="flex items-center justify-end mt-4">
                          <a href="{{ route('employees.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">{{ __('Cancel') }}</a>
                          <x-button>
                              {{ __('Create Employee') }}
                          </x-button>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>
</x-app-layout>