<x-app-layout>
  <x-slot name="header">
      <div class="flex justify-between items-center">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              {{ __('Training Details') }}
          </h2>
          <div class="flex space-x-2">
              @can('update', $training)
                  <a href="{{ route('trainings.edit', $training) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-500 active:bg-yellow-700 focus:outline-none focus:border-yellow-700 focus:ring focus:ring-yellow-300 disabled:opacity-25 transition">
                      {{ __('Edit') }}
                  </a>
              @endcan
              <a href="{{ route('trainings.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                  {{ __('Back to Trainings') }}
              </a>
          </div>
      </div>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
          <!-- Training Information Card -->
          <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
              <div class="p-6 bg-white border-b border-gray-200">
                  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                      <div class="md:col-span-1">
                          <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Training Information') }}</h3>
                          <div class="space-y-4">
                              <div>
                                  <span class="text-sm text-gray-500">{{ __('Training Name') }}</span>
                                  <p class="text-gray-800 font-medium">{{ $training->name }}</p>
                              </div>
                              
                              <div>
                                  <span class="text-sm text-gray-500">{{ __('Status') }}</span>
                                  <p class="text-gray-800">
                                      @php
                                          $now = now();
                                          $status = '';
                                          $statusClass = '';
                                          
                                          if (!$training->start_date && !$training->end_date) {
                                              $status = 'Not scheduled';
                                              $statusClass = 'bg-gray-100 text-gray-800';
                                          } elseif ($training->start_date && $now < $training->start_date) {
                                              $status = 'Upcoming';
                                              $statusClass = 'bg-blue-100 text-blue-800';
                                          } elseif ($training->end_date && $now > $training->end_date) {
                                              $status = 'Completed';
                                              $statusClass = 'bg-green-100 text-green-800';
                                          } else {
                                              $status = 'In Progress';
                                              $statusClass = 'bg-yellow-100 text-yellow-800';
                                          }
                                      @endphp
                                      <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                          {{ $status }}
                                      </span>
                                  </p>
                              </div>
                              
                              <div>
                                  <span class="text-sm text-gray-500">{{ __('Start Date') }}</span>
                                  <p class="text-gray-800">{{ $training->start_date ? $training->start_date->format('M d, Y') : 'Not specified' }}</p>
                              </div>
                              
                              <div>
                                  <span class="text-sm text-gray-500">{{ __('End Date') }}</span>
                                  <p class="text-gray-800">{{ $training->end_date ? $training->end_date->format('M d, Y') : 'Not specified' }}</p>
                              </div>
                              
                              @if($training->start_date && $training->end_date)
                                  <div>
                                      <span class="text-sm text-gray-500">{{ __('Duration') }}</span>
                                      <p class="text-gray-800">{{ $training->start_date->diffInDays($training->end_date) + 1 }} days</p>
                                  </div>
                              @endif
                              
                              <div>
                                  <span class="text-sm text-gray-500">{{ __('Participants') }}</span>
                                  <p class="text-gray-800">{{ $training->employees->count() }} {{ __('employees') }}</p>
                              </div>
                          </div>
                      </div>
                      
                      <div class="md:col-span-2">
                          <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Description') }}</h3>
                          <div class="bg-gray-50 p-4 rounded-md text-gray-700">
                              {!! nl2br(e($training->description)) ?: '<em class="text-gray-500">No description provided</em>' !!}
                          </div>
                          
                          @if($training->getMedia('training_documents')->count() > 0)
                              <h3 class="text-lg font-medium text-gray-900 mt-8 mb-4">{{ __('Training Materials') }}</h3>
                              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                  @foreach($training->getMedia('training_documents') as $document)
                                      <div class="bg-gray-50 p-4 rounded-md border border-gray-200 flex items-center">
                                          @php
                                              $extension = pathinfo($document->file_name, PATHINFO_EXTENSION);
                                              $iconClass = match($extension) {
                                                  'pdf' => 'text-red-600',
                                                  'doc', 'docx' => 'text-blue-600',
                                                  'ppt', 'pptx' => 'text-orange-600',
                                                  default => 'text-gray-600'
                                              };
                                          @endphp
                                          
                                          <svg class="h-8 w-8 {{ $iconClass }} mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                              <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                          </svg>
                                          
                                          <div class="flex-1">
                                              <p class="text-sm font-medium text-gray-900 truncate">
                                                  {{ $document->name ?: $document->file_name }}
                                              </p>
                                              <p class="text-xs text-gray-500">
                                                  {{ Str::upper($extension) }} · {{ round($document->size / 1024) }} KB
                                              </p>
                                          </div>
                                          
                                          <a href="{{ $document->getUrl() }}" target="_blank" class="inline-flex items-center px-3 py-1 border border-transparent text-xs leading-4 font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                              Download
                                          </a>
                                      </div>
                                  @endforeach
                              </div>
                          @endif
                      </div>
                  </div>
              </div>
          </div>
          
          <!-- Participants Card -->
          <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
              <div class="p-6 bg-white border-b border-gray-200">
                  <div class="flex justify-between items-center mb-6">
                      <h3 class="text-lg font-medium text-gray-900">{{ __('Participants') }} ({{ $training->employees->count() }})</h3>
                      @can('update', $training)
                          <button id="assignEmployeesBtn" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-300 disabled:opacity-25 transition">
                              {{ __('Assign Employees') }}
                          </button>
                      @endcan
                  </div>
                  
                  @if($training->employees->count() > 0)
                      <div class="overflow-x-auto">
                          <table class="min-w-full divide-y divide-gray-200">
                              <thead class="bg-gray-50">
                                  <tr>
                                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                          {{ __('Employee') }}
                                      </th>
                                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                          {{ __('Department') }}
                                      </th>
                                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                          {{ __('Status') }}
                                      </th>
                                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                          {{ __('Actions') }}
                                      </th>
                                  </tr>
                              </thead>
                              <tbody class="bg-white divide-y divide-gray-200">
                                  @foreach($training->employees as $employee)
                                      <tr>
                                          <td class="px-6 py-4 whitespace-nowrap">
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
                                                      <div class="text-sm font-medium text-gray-900">
                                                          {{ $employee->user->name }}
                                                      </div>
                                                      <div class="text-sm text-gray-500">
                                                          {{ $employee->position ?: 'No position' }}
                                                      </div>
                                                  </div>
                                              </div>
                                          </td>
                                          <td class="px-6 py-4 whitespace-nowrap">
                                              <div class="text-sm text-gray-900">{{ $employee->department ? $employee->department->name : 'N/A' }}</div>
                                          </td>
                                          <td class="px-6 py-4 whitespace-nowrap">
                                              <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                  @if($employee->pivot->status == 'Completed') bg-green-100 text-green-800 
                                                  @elseif($employee->pivot->status == 'In Progress') bg-blue-100 text-blue-800 
                                                  @elseif($employee->pivot->status == 'Failed') bg-red-100 text-red-800 
                                                  @else bg-yellow-100 text-yellow-800 @endif">
                                                  {{ $employee->pivot->status }}
                                              </span>
                                          </td>
                                          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                              @can('update', $training)
                                                  <button type="button" 
                                                          data-employee-id="{{ $employee->id }}"
                                                          data-employee-name="{{ $employee->user->name }}"
                                                          data-status="{{ $employee->pivot->status }}"
                                                          class="text-indigo-600 hover:text-indigo-900 update-status-btn">
                                                      Update Status
                                                  </button>
                                              @endcan
                                          </td>
                                      </tr>
                                  @endforeach
                              </tbody>
                          </table>
                      </div>
                  @else
                      <div class="bg-gray-50 p-6 text-center rounded-md">
                          <p class="text-gray-500">{{ __('No employees have been assigned to this training yet.') }}</p>
                      </div>
                  @endif
              </div>
          </div>
      </div>
  </div>

  <!-- Assign Employees Modal -->
  <div id="assignEmployeesModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
      <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
          <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
          <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
          <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
              <form action="{{ route('trainings.employees.assign', $training) }}" method="POST">
                  @csrf
                  <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                      <div class="sm:flex sm:items-start">
                          <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                              <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                  {{ __('Assign Employees to Training') }}
                              </h3>
                              <div class="mt-4">
                                  <p class="text-sm text-gray-500 mb-4">
                                      {{ __('Select employees to participate in this training. Currently assigned employees are pre-selected.') }}
                                  </p>
                                  
                                  <div class="max-h-60 overflow-y-auto p-2 border rounded-md">
                                      @foreach(\App\Models\Employee::with('user', 'department')->get() as $emp)
                                          <div class="flex items-center space-x-3 py-2 border-b border-gray-100">
                                              <input type="checkbox" 
                                                     id="employee-{{ $emp->id }}" 
                                                     name="employees[]" 
                                                     value="{{ $emp->id }}"
                                                     class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                                     {{ $training->employees->contains($emp) ? 'checked' : '' }}>
                                              <label for="employee-{{ $emp->id }}" class="flex-1 flex items-center">
                                                  <div class="flex-shrink-0 h-8 w-8 mr-3">
                                                      @if($emp->user->profile_photo_url)
                                                          <img class="h-8 w-8 rounded-full" src="{{ $emp->user->profile_photo_url }}" alt="{{ $emp->user->name }}">
                                                      @else
                                                          <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">
                                                              <span class="text-gray-500 text-xs">{{ substr($emp->user->name, 0, 1) }}</span>
                                                          </div>
                                                      @endif
                                                  </div>
                                                  <div>
                                                      <div class="text-sm font-medium text-gray-900">{{ $emp->user->name }}</div>
                                                      <div class="text-xs text-gray-500">
                                                          {{ $emp->department ? $emp->department->name : 'No department' }} · {{ $emp->position ?: 'No position' }}
                                                      </div>
                                                  </div>
                                              </label>
                                          </div>
                                      @endforeach
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                      <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                          {{ __('Assign') }}
                      </button>
                      <button type="button" id="cancelAssignBtn" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                          {{ __('Cancel') }}
                      </button>
                  </div>
              </form>
          </div>
      </div>
  </div>

  <!-- Update Status Modal -->
  <div id="updateStatusModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
      <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
          <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
          <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
          <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
              <form id="updateStatusForm" method="POST">
                  @csrf
                  @method('PATCH')
                  <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                      <div class="sm:flex sm:items-start">
                          <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                              <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                  {{ __('Update Training Status') }}
                              </h3>
                              <div class="mt-4">
                                  <p class="text-sm text-gray-500 mb-4" id="employeeName">
                                      {{ __('Update training status for') }} <span class="font-medium">Employee Name</span>
                                  </p>
                                  
                                  <x-label for="status" value="{{ __('Status') }}" />
                                  <x-select id="statusSelect" class="block mt-1 w-full" name="status" required>
                                      <option value="Pending">{{ __('Pending') }}</option>
                                      <option value="In Progress">{{ __('In Progress') }}</option>
                                      <option value="Completed">{{ __('Completed') }}</option>
                                      <option value="Failed">{{ __('Failed') }}</option>
                                  </x-select>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                      <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                          {{ __('Update') }}
                      </button>
                      <button type="button" id="cancelStatusBtn" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                          {{ __('Cancel') }}
                      </button>
                  </div>
              </form>
          </div>
      </div>
  </div>

  <script>
      document.addEventListener('DOMContentLoaded', function() {
          // Assign Employees Modal
          const assignEmployeesModal = document.getElementById('assignEmployeesModal');
          const assignEmployeesBtn = document.getElementById('assignEmployeesBtn');
          const cancelAssignBtn = document.getElementById('cancelAssignBtn');
          
          if (assignEmployeesBtn) {
              assignEmployeesBtn.addEventListener('click', function() {
                  assignEmployeesModal.classList.remove('hidden');
              });
          }
          
          if (cancelAssignBtn) {
              cancelAssignBtn.addEventListener('click', function() {
                  assignEmployeesModal.classList.add('hidden');
              });
          }
          
          // Update Status Modal
          const updateStatusModal = document.getElementById('updateStatusModal');
          const updateStatusBtns = document.querySelectorAll('.update-status-btn');
          const cancelStatusBtn = document.getElementById('cancelStatusBtn');
          const updateStatusForm = document.getElementById('updateStatusForm');
          const employeeNameEl = document.getElementById('employeeName');
          const statusSelect = document.getElementById('statusSelect');
          
          updateStatusBtns.forEach(btn => {
              btn.addEventListener('click', function() {
                  const employeeId = this.dataset.employeeId;
                  const employeeName = this.dataset.employeeName;
                  const status = this.dataset.status;
                  
                  // Set form action URL
                  updateStatusForm.action = `{{ route('trainings.employees.status', ['training' => $training->id, 'employee' => '']) }}/${employeeId}`;
                  
                  // Set employee name and current status
                  employeeNameEl.innerHTML = `{{ __('Update training status for') }} <span class="font-medium">${employeeName}</span>`;
                  statusSelect.value = status;
                  
                  // Show modal
                  updateStatusModal.classList.remove('hidden');
              });
          });
          
          if (cancelStatusBtn) {
              cancelStatusBtn.addEventListener('click', function() {
                  updateStatusModal.classList.add('hidden');
              });
          }
      });
  </script>
</x-app-layout>