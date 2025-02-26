<x-app-layout>
  <!-- Previous content... -->

  <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
      <div class="p-6 bg-white border-b border-gray-200">
          <div class="flex justify-between items-center mb-4">
              <h3 class="text-lg font-medium text-gray-900">{{ __('Contracts') }}</h3>
              @can('create', App\Models\Contract::class)
                  <a href="{{ route('contracts.create', ['employee_id' => $employee->id]) }}" class="inline-flex items-center px-3 py-1 bg-indigo-600 border border-transparent rounded-md text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-300 disabled:opacity-25 transition">
                      {{ __('Add Contract') }}
                  </a>
              @endcan
          </div>
          
          @if($employee->contracts->count() > 0)
              <div class="overflow-x-auto">
                  <table class="min-w-full divide-y divide-gray-200">
                      <thead class="bg-gray-50">
                          <tr>
                              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                  {{ __('Type') }}
                              </th>
                              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                  {{ __('Start Date') }}
                              </th>
                              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                  {{ __('End Date') }}
                              </th>
                              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                  {{ __('Status') }}
                              </th>
                              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                  {{ __('Action') }}
                              </th>
                          </tr>
                      </thead>
                      <tbody class="bg-white divide-y divide-gray-200">
                          @foreach($employee->contracts as $contract)
                              <tr>
                                  <td class="px-6 py-4 whitespace-nowrap">
                                      <div class="text-sm font-medium text-gray-900">
                                          {{ $contract->type }}
                                      </div>
                                  </td>
                                  <td class="px-6 py-4 whitespace-nowrap">
                                      <div class="text-sm text-gray-500">
                                          {{ $contract->start_date->format('M d, Y') }}
                                      </div>
                                  </td>
                                  <td class="px-6 py-4 whitespace-nowrap">
                                      <div class="text-sm text-gray-500">
                                          {{ $contract->end_date ? $contract->end_date->format('M d, Y') : 'Indefinite' }}
                                      </div>
                                  </td>
                                  <td class="px-6 py-4 whitespace-nowrap">
                                      <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $contract->end_date && $contract->end_date < now() ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                          {{ $contract->end_date && $contract->end_date < now() ? 'Expired' : 'Active' }}
                                      </span>
                                  </td>
                                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                      <a href="{{ route('contracts.show', $contract) }}" class="text-indigo-600 hover:text-indigo-900">
                                          {{ __('View') }}
                                      </a>
                                  </td>
                              </tr>
                          @endforeach
                      </tbody>
                  </table>
              </div>
          @else
              <p class="text-gray-500">{{ __('No contracts found.') }}</p>
          @endif
      </div>
  </div>

  <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-6">
      <div class="p-6 bg-white border-b border-gray-200">
          <div class="flex justify-between items-center mb-4">
              <h3 class="text-lg font-medium text-gray-900">{{ __('Career Development') }}</h3>
              @can('create', App\Models\CareerDevelopment::class)
                  <a href="{{ route('career-developments.create', ['employee_id' => $employee->id]) }}" class="inline-flex items-center px-3 py-1 bg-indigo-600 border border-transparent rounded-md text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-300 disabled:opacity-25 transition">
                      {{ __('Add Development') }}
                  </a>
              @endcan
          </div>
          
          @if($employee->careerDevelopments->count() > 0)
              <div class="overflow-x-auto">
                  <table class="min-w-full divide-y divide-gray-200">
                      <thead class="bg-gray-50">
                          <tr>
                              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                  {{ __('Type') }}
                              </th>
                              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                  {{ __('Date') }}
                              </th>
                              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                  {{ __('Previous Value') }}
                              </th>
                              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                  {{ __('New Value') }}
                              </th>
                              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                  {{ __('Action') }}
                              </th>
                          </tr>
                      </thead>
                      <tbody class="bg-white divide-y divide-gray-200">
                          @foreach($employee->careerDevelopments->sortByDesc('date') as $development)
                              <tr>
                                  <td class="px-6 py-4 whitespace-nowrap">
                                      <div class="text-sm font-medium text-gray-900">
                                          {{ $development->type }}
                                      </div>
                                  </td>
                                  <td class="px-6 py-4 whitespace-nowrap">
                                      <div class="text-sm text-gray-500">
                                          {{ $development->date->format('M d, Y') }}
                                      </div>
                                  </td>
                                  <td class="px-6 py-4 whitespace-nowrap">
                                      <div class="text-sm text-gray-500">
                                          {{ $development->previous_value ?: 'N/A' }}
                                      </div>
                                  </td>
                                  <td class="px-6 py-4 whitespace-nowrap">
                                      <div class="text-sm text-gray-500">
                                          {{ $development->new_value ?: 'N/A' }}
                                      </div>
                                  </td>
                                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                      <a href="{{ route('career-developments.show', $development) }}" class="text-indigo-600 hover:text-indigo-900">
                                          {{ __('View') }}
                                      </a>
                                  </td>
                              </tr>
                          @endforeach
                      </tbody>
                  </table>
              </div>
          @else
              <p class="text-gray-500">{{ __('No career developments found.') }}</p>
          @endif
      </div>
  </div>

  <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-6">
      <div class="p-6 bg-white border-b border-gray-200">
          <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Trainings') }}</h3>
          
          @if($employee->trainings->count() > 0)
              <div class="overflow-x-auto">
                  <table class="min-w-full divide-y divide-gray-200">
                      <thead class="bg-gray-50">
                          <tr>
                              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                  {{ __('Name') }}
                              </th>
                              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                  {{ __('Start Date') }}
                              </th>
                              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                  {{ __('End Date') }}
                              </th>
                              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                  {{ __('Status') }}
                              </th>
                              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                  {{ __('Action') }}
                              </th>
                          </tr>
                      </thead>
                      <tbody class="bg-white divide-y divide-gray-200">
                          @foreach($employee->trainings as $training)
                              <tr>
                                  <td class="px-6 py-4 whitespace-nowrap">
                                      <div class="text-sm font-medium text-gray-900">
                                          {{ $training->name }}
                                      </div>
                                  </td>
                                  <td class="px-6 py-4 whitespace-nowrap">
                                      <div class="text-sm text-gray-500">
                                          {{ $training->start_date ? $training->start_date->format('M d, Y') : 'N/A' }}
                                      </div>
                                  </td>
                                  <td class="px-6 py-4 whitespace-nowrap">
                                      <div class="text-sm text-gray-500">
                                          {{ $training->end_date ? $training->end_date->format('M d, Y') : 'N/A' }}
                                      </div>
                                  </td>
                                  <td class="px-6 py-4 whitespace-nowrap">
                                      <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                          @if($training->pivot->status == 'Completed') bg-green-100 text-green-800 
                                          @elseif($training->pivot->status == 'In Progress') bg-blue-100 text-blue-800 
                                          @elseif($training->pivot->status == 'Failed') bg-red-100 text-red-800 
                                          @else bg-yellow-100 text-yellow-800 @endif">
                                          {{ $training->pivot->status }}
                                      </span>
                                  </td>
                                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                      <a href="{{ route('trainings.show', $training) }}" class="text-indigo-600 hover:text-indigo-900">
                                          {{ __('View') }}
                                      </a>
                                  </td>
                              </tr>
                          @endforeach
                      </tbody>
                  </table>
              </div>
          @else
              <p class="text-gray-500">{{ __('No trainings found.') }}</p>
          @endif
      </div>
  </div>

</div>
</div>
</x-app-layout>