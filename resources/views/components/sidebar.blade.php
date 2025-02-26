<div class="bg-gray-800 text-white w-64 space-y-6 py-7 px-2 absolute inset-y-0 left-0 transform -translate-x-full md:relative md:translate-x-0 transition duration-200 ease-in-out">
  <a href="{{ route('dashboard') }}" class="text-white flex items-center space-x-2 px-4">
      <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
      </svg>
      <span class="text-xl font-bold">{{ config('app.name', 'Employee Management') }}</span>
  </a>

  <nav>
      <a href="{{ route('dashboard') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white {{ request()->routeIs('dashboard') ? 'bg-gray-700' : '' }}">
          Dashboard
      </a>
      @can('manage companies')
          <a href="{{ route('companies.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white {{ request()->routeIs('companies.*') ? 'bg-gray-700' : '' }}">
              Companies
          </a>
      @endcan
      @can('manage departments')
          <a href="{{ route('departments.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white {{ request()->routeIs('departments.*') ? 'bg-gray-700' : '' }}">
              Departments
          </a>
      @endcan
      @can('manage employees')
          <a href="{{ route('employees.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white {{ request()->routeIs('employees.*') ? 'bg-gray-700' : '' }}">
              Employees
          </a>
      @endcan
      @can('manage contracts')
          <a href="{{ route('contracts.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white {{ request()->routeIs('contracts.*') ? 'bg-gray-700' : '' }}">
              Contracts
          </a>
      @endcan
      @can('manage career developments')
          <a href="{{ route('career-developments.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white {{ request()->routeIs('career-developments.*') ? 'bg-gray-700' : '' }}">
              Career Developments
          </a>
      @endcan
      @can('manage trainings')
          <a href="{{ route('trainings.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white {{ request()->routeIs('trainings.*') ? 'bg-gray-700' : '' }}">
              Trainings
          </a>
      @endcan
      @can('view org chart')
          <a href="{{ route('org-chart.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white {{ request()->routeIs('org-chart.*') ? 'bg-gray-700' : '' }}">
              Organization Chart
          </a>
      @endcan
  </nav>
</div>
