<x-app-layout>
  <!-- Previous content... -->
  
  <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
      <div class="px-6 py-5 border-b border-gray-200">
          <h3 class="text-lg font-medium text-gray-900">{{ __('Your Recent Trainings') }}</h3>
      </div>
      <div class="p-6">
          @if(Auth::user()->employee->trainings->count() > 0)
              <div class="space-y-4">
                  @foreach(Auth::user()->employee->trainings->take(3) as $training)
                      <div class="border rounded-lg p-4 hover:bg-gray-50">
                          <div class="flex justify-between items-center">
                              <div>
                                  <h4 class="text-lg font-medium text-gray-900">{{ $training->name }}</h4>
                                  <p class="text-gray-500 text-sm mt-1">
                                      {{ $training->start_date ? $training->start_date->format('M d, Y') : 'No Start Date' }} - 
                                      {{ $training->end_date ? $training->end_date->format('M d, Y') : 'No End Date' }}
                                  </p>
                              </div>
                              <span class="px-2 py-1 text-xs rounded-full 
                                  @if($training->pivot->status == 'Completed') bg-green-100 text-green-800 
                                  @elseif($training->pivot->status == 'In Progress') bg-blue-100 text-blue-800 
                                  @elseif($training->pivot->status == 'Failed') bg-red-100 text-red-800 
                                  @else bg-yellow-100 text-yellow-800 @endif">
                                  {{ $training->pivot->status }}
                              </span>
                          </div>
                          <p class="text-gray-600 mt-2">{{ Str::limit($training->description, 100) }}</p>
                          <div class="mt-3">
                              <a href="{{ route('trainings.show', $training) }}" class="text-sm text-indigo-600 hover:text-indigo-500">
                                  {{ __('View details') }} →
                              </a>
                          </div>
                      </div>
                  @endforeach
              </div>
              
              @if(Auth::user()->employee->trainings->count() > 3)
                  <div class="mt-4 text-center">
                      <a href="{{ route('trainings.index') }}" class="text-sm text-indigo-600 font-medium hover:text-indigo-500">
                          {{ __('View all trainings') }} →
                      </a>
                  </div>
              @endif
          @else
              <div class="text-center py-4">
                  <p class="text-gray-500">{{ __('You have no trainings assigned yet.') }}</p>
              </div>
          @endif
      </div>
  </div>

  <!-- Contracts Section -->
  <div class="mt-6 bg-white overflow-hidden shadow-xl sm:rounded-lg">
      <div class="px-6 py-5 border-b border-gray-200">
          <h3 class="text-lg font-medium text-gray-900">{{ __('Your Contracts') }}</h3>
      </div>
      <div class="p-6">
          @if(Auth::user()->employee->contracts->count() > 0)
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
                          @foreach(Auth::user()->employee->contracts as $contract)
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
              <div class="text-center py-4">
                  <p class="text-gray-500">{{ __('You have no contracts recorded in the system.') }}</p>
              </div>
          @endif
      </div>
  </div>

  <!-- Career Development Section -->
  <div class="mt-6 bg-white overflow-hidden shadow-xl sm:rounded-lg">
      <div class="px-6 py-5 border-b border-gray-200">
          <h3 class="text-lg font-medium text-gray-900">{{ __('Your Career Progress') }}</h3>
      </div>
      <div class="p-6">
          @if(Auth::user()->employee->careerDevelopments->count() > 0)
              <div class="relative">
                  <!-- Timeline line -->
                  <div class="absolute h-full w-0.5 bg-gray-200 left-5 top-0"></div>
                  
                  <div class="space-y-8 relative">
                      @foreach(Auth::user()->employee->careerDevelopments->sortByDesc('date') as $development)
                          <div class="flex items-start">
                              <!-- Timeline dot -->
                              <div class="absolute left-5 mt-1.5 -ml-2.5">
                                  <div class="h-5 w-5 rounded-full border-4 border-white bg-indigo-500"></div>
                              </div>
                              
                              <!-- Content -->
                              <div class="ml-10">
                                  <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
                                      <h4 class="text-md font-medium text-gray-900">{{ $development->type }}</h4>
                                      <span class="text-sm text-gray-500">{{ $development->date->format('M d, Y') }}</span>
                                  </div>
                                  
                                  <div class="mt-2 text-sm text-gray-500 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                      <div>
                                          <span class="font-medium text-gray-900">{{ __('Previous') }}:</span> 
                                          {{ $development->previous_value ?: 'N/A' }}
                                      </div>
                                      <div>
                                          <span class="font-medium text-gray-900">{{ __('New') }}:</span> 
                                          {{ $development->new_value ?: 'N/A' }}
                                      </div>
                                  </div>
                                  
                                  @if($development->description)
                                      <div class="mt-1 text-sm text-gray-600">
                                          {{ $development->description }}
                                      </div>
                                  @endif
                              </div>
                          </div>
                      @endforeach
                  </div>
              </div>
          @else
              <div class="text-center py-4">
                  <p class="text-gray-500">{{ __('No career developments recorded yet.') }}</p>
              </div>
          @endif
      </div>
  </div>
</div>
</x-app-layout>