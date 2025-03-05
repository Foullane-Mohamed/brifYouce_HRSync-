
<nav class="bg-white border-b border-gray-200">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
          <div class="flex">
              <!-- Logo -->
              <div class="shrink-0 flex items-center">
                  <a href="{{ route('dashboard') }}" class="font-bold text-xl text-blue-600">
                      EMS
                  </a>
              </div>

              <!-- Navigation Links -->
              <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                  @if(auth()->user()->isAdmin())
                      <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'border-b-2 border-indigo-500 text-gray-900' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300' }} inline-flex items-center px-1 pt-1 text-sm font-medium">
                          Dashboard
                      </a>
                      <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'border-b-2 border-indigo-500 text-gray-900' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300' }} inline-flex items-center px-1 pt-1 text-sm font-medium">
                          Users
                      </a>
                      <a href="{{ route('admin.departments.index') }}" class="{{ request()->routeIs('admin.departments.*') ? 'border-b-2 border-indigo-500 text-gray-900' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300' }} inline-flex items-center px-1 pt-1 text-sm font-medium">
                          Departments
                      </a>
                      <a href="{{ route('admin.leave-requests.index') }}" class="{{ request()->routeIs('admin.leave-requests.*') ? 'border-b-2 border-indigo-500 text-gray-900' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300' }} inline-flex items-center px-1 pt-1 text-sm font-medium">
                          Leave hr and employee
                      </a>
                  @elseif(auth()->user()->isHR())
                      <a href="{{ route('hr.dashboard') }}" class="{{ request()->routeIs('hr.dashboard') ? 'border-b-2 border-indigo-500 text-gray-900' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300' }} inline-flex items-center px-1 pt-1 text-sm font-medium">
                          Dashboard
                      </a>
                      <a href="{{ route('hr.employees.index') }}" class="{{ request()->routeIs('hr.employees.*') ? 'border-b-2 border-indigo-500 text-gray-900' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300' }} inline-flex items-center px-1 pt-1 text-sm font-medium">
                          Employees
                      </a>
                      <a href="{{ route('hr.leave-requests.index') }}" class="{{ request()->routeIs('hr.leave-requests.*') ? 'border-b-2 border-indigo-500 text-gray-900' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300' }} inline-flex items-center px-1 pt-1 text-sm font-medium">
                          Leave Requests
                      </a>
                      <a href="{{ route('hr.attendance.index') }}" class="{{ request()->routeIs('hr.attendance.*') ? 'border-b-2 border-indigo-500 text-gray-900' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300' }} inline-flex items-center px-1 pt-1 text-sm font-medium">
                          Attendance
                      </a>
                      <a href="{{ route('hr.performance-reviews.index') }}" class="{{ request()->routeIs('hr.performance-reviews.*') ? 'border-b-2 border-indigo-500 text-gray-900' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300' }} inline-flex items-center px-1 pt-1 text-sm font-medium">
                          Performance
                      </a>
                  @else
                      <a href="{{ route('employee.dashboard') }}" class="{{ request()->routeIs('employee.dashboard') ? 'border-b-2 border-indigo-500 text-gray-900' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300' }} inline-flex items-center px-1 pt-1 text-sm font-medium">
                          Dashboard
                      </a>
                      <a href="{{ route('employee.leave-requests.index') }}" class="{{ request()->routeIs('employee.leave-requests.*') ? 'border-b-2 border-indigo-500 text-gray-900' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300' }} inline-flex items-center px-1 pt-1 text-sm font-medium">
                          Leave Requests
                      </a>
                      <a href="{{ route('employee.attendance.index') }}" class="{{ request()->routeIs('employee.attendance.*') ? 'border-b-2 border-indigo-500 text-gray-900' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300' }} inline-flex items-center px-1 pt-1 text-sm font-medium">
                          Attendance
                      </a>
                      <a href="{{ route('employee.performance-reviews.index') }}" class="{{ request()->routeIs('employee.performance-reviews.*') ? 'border-b-2 border-indigo-500 text-gray-900' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300' }} inline-flex items-center px-1 pt-1 text-sm font-medium">
                          Performance
                      </a>
                  @endif
              </div>
          </div>

          <!-- Settings Dropdown -->
          <div class="hidden sm:flex sm:items-center sm:ml-6">
              <div class="relative" x-data="{ open: false }" @click.away="open = false" @close.stop="open = false">
                  <div @click="open = ! open">
                      <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                          <div>{{ Auth::user()->name }}</div>

                          <div class="ml-1">
                              <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                  <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                              </svg>
                          </div>
                      </button>
                  </div>

                  <div x-show="open"
                          x-transition:enter="transition ease-out duration-200"
                          x-transition:enter-start="transform opacity-0 scale-95"
                          x-transition:enter-end="transform opacity-100 scale-100"
                          x-transition:leave="transition ease-in duration-75"
                          x-transition:leave-start="transform opacity-100 scale-100"
                          x-transition:leave-end="transform opacity-0 scale-95"
                          class="absolute right-0 z-50 mt-2 w-48 rounded-md shadow-lg origin-top-right"
                          style="display: none;">
                      <div class="rounded-md ring-1 ring-black ring-opacity-5 py-1 bg-white">
                          <!-- Profile -->
                          <a href="{{ route('employee.profile') }}" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                              Profile
                          </a>

                          <!-- Authentication -->
                          <form method="POST" action="{{ route('logout') }}">
                              @csrf
                              <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                                      onclick="event.preventDefault(); this.closest('form').submit();">
                                  Log Out
                              </a>
                          </form>
                      </div>
                  </div>
              </div>
          </div>

          <!-- Hamburger -->
          <div class="-mr-2 flex items-center sm:hidden">
              <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                  <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                      <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                      <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                  </svg>
              </button>
          </div>
      </div>
  </div>

  <!-- Responsive Navigation Menu -->
  <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
      <div class="pt-2 pb-3 space-y-1">
          @if(auth()->user()->isAdmin())
              <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'bg-indigo-50 border-indigo-500 text-indigo-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                  Dashboard
              </a>
              <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'bg-indigo-50 border-indigo-500 text-indigo-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                  Users
              </a>
              <a href="{{ route('admin.departments.index') }}" class="{{ request()->routeIs('admin.departments.*') ? 'bg-indigo-50 border-indigo-500 text-indigo-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                  Departments
              </a>
              <a href="{{ route('admin.leave-requests.index') }}" class="{{ request()->routeIs('admin.leave-requests.*') ? 'bg-indigo-50 border-indigo-500 text-indigo-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                  Leave Requests
              </a>
          @elseif(auth()->user()->isHR())
              <!-- HR Responsive Menu -->
              <a href="{{ route('hr.dashboard') }}" class="{{ request()->routeIs('hr.dashboard') ? 'bg-indigo-50 border-indigo-500 text-indigo-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                  Dashboard
              </a>
              <a href="{{ route('hr.employees.index') }}" class="{{ request()->routeIs('hr.employees.*') ? 'bg-indigo-50 border-indigo-500 text-indigo-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                  Employees
              </a>
              <a href="{{ route('hr.leave-requests.index') }}" class="{{ request()->routeIs('hr.leave-requests.*') ? 'bg-indigo-50 border-indigo-500 text-indigo-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                  Leave Requests
              </a>
              <a href="{{ route('hr.attendance.index') }}" class="{{ request()->routeIs('hr.attendance.*') ? 'bg-indigo-50 border-indigo-500 text-indigo-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                  Attendance
              </a>
              <a href="{{ route('hr.performance-reviews.index') }}" class="{{ request()->routeIs('hr.performance-reviews.*') ? 'bg-indigo-50 border-indigo-500 text-indigo-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                  Performance
              </a>
          @else
              <!-- Employee Responsive Menu -->
              <a href="{{ route('employee.dashboard') }}" class="{{ request()->routeIs('employee.dashboard') ? 'bg-indigo-50 border-indigo-500 text-indigo-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                  Dashboard
              </a>
              <a href="{{ route('employee.leave-requests.index') }}" class="{{ request()->routeIs('employee.leave-requests.*') ? 'bg-indigo-50 border-indigo-500 text-indigo-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                  Leave Requests
              </a>
              <a href="{{ route('employee.attendance.index') }}" class="{{ request()->routeIs('employee.attendance.*') ? 'bg-indigo-50 border-indigo-500 text-indigo-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                  Attendance
              </a>
              <a href="{{ route('employee.performance-reviews.index') }}" class="{{ request()->routeIs('employee.performance-reviews.*') ? 'bg-indigo-50 border-indigo-500 text-indigo-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                  Performance
              </a>
          @endif
      </div>

      <!-- Responsive Settings Options -->
      <div class="pt-4 pb-1 border-t border-gray-200">
          <div class="px-4">
              <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
              <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
          </div>

          <div class="mt-3 space-y-1">
              <!-- Profile -->
              <a href="{{ route('employee.profile') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300">
                  Profile
              </a>

              <!-- Authentication -->
              <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <a href="{{ route('logout') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300"
                          onclick="event.preventDefault(); this.closest('form').submit();">
                      Log Out
                  </a>
              </form>
          </div>
      </div>
  </div>
</nav>