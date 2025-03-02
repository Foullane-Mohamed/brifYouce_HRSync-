<x-app-layout>
  <x-slot name="header">
      <div class="flex justify-between items-center">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              {{ __('Trainings') }}
          </h2>
          @can('create', App\Models\Training::class)
              <a href="{{ route('trainings.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                  {{ __('Add Training') }}
              </a>
          @endcan
      </div>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
              <div class="p-6 bg-white border-b border-gray-200">
                  <div class="overflow-x-auto">
                      <table class="min-w-full divide-y divide-gray-200">
                          <thead class="bg-gray-50">
                              <tr>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                      {{ __('Training') }}
                                  </th>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                      {{ __('Period') }}
                                  </th>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                      {{ __('Status') }}
                                  </th>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                      {{ __('Participants') }}
                                  </th>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                      {{ __('Documents') }}
                                  </th>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                      {{ __('Actions') }}
                                  </th>
                              </tr>
                          </thead>
                          <tbody class="bg-white divide-y divide-gray-200">
                              @forelse($trainings as $training)
                                  <tr>
                                      <td class="px-6 py-4">
                                          <div class="flex items-center">
                                              <div class="ml-4">
                                                  <div class="text-sm font-medium text-gray-900">
                                                      {{ $training->name }}
                                                  </div>
                                                  @if($training->description)
                                                      <div class="text-sm text-gray-500 truncate max-w-xs">
                                                          {{ Str::limit($training->description, 50) }}
                                                      </div>
                                                  @endif
                                              </div>
                                          </div>
                                      </td>
                                      <td class="px-6 py-4 whitespace-nowrap">
                                          <div class="text-sm text-gray-900">
                                              @if($training->start_date && $training->end_date)
                                                  {{ $training->start_date->format('M d, Y') }} - {{ $training->end_date->format('M d, Y') }}
                                              @elseif($training->start_date)
                                                  From {{ $training->start_date->format('M d, Y') }}
                                              @elseif($training->end_date)
                                                  Until {{ $training->end_date->format('M d, Y') }}
                                              @else
                                                  No dates specified
                                              @endif
                                          </div>
                                          @if($training->start_date && $training->end_date)
                                              <div class="text-xs text-gray-500">
                                                  Duration: {{ $training->start_date->diffInDays($training->end_date) + 1 }} days
                                              </div>
                                          @endif
                                      </td>
                                      <td class="px-6 py-4 whitespace-nowrap">
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
                                      </td>
                                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                          {{ $training->employees->count() }}
                                          <div class="flex -space-x-2 overflow-hidden mt-1">
                                              @foreach($training->employees->take(5) as $employee)
                                                  <div class="inline-block h-6 w-6 rounded-full ring-2 ring-white {{ $loop->index > 2 ? 'opacity-75' : '' }}" 
                                                       title="{{ $employee->user->name }}">
                                                      @if($employee->user->profile_photo_url)
                                                          <img class="h-6 w-6 rounded-full" src="{{ $employee->user->profile_photo_url }}" alt="{{ $employee->user->name }}">
                                                      @else
                                                          <div class="h-6 w-6 rounded-full bg-gray-200 flex items-center justify-center">
                                                              <span class="text-gray-500 text-xs">{{ substr($employee->user->name, 0, 1) }}</span>
                                                          </div>
                                                      @endif
                                                  </div>
                                              @endforeach
                                              @if($training->employees->count() > 5)
                                                  <div class="inline-flex h-6 w-6 rounded-full bg-gray-300 items-center justify-center text-xs font-medium text-gray-800 ring-2 ring-white">
                                                      +{{ $training->employees->count() - 5 }}
                                                  </div>
                                              @endif
                                          </div>
                                      </td>
                                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                          {{ $training->getMedia('training_documents')->count() }}
                                      </td>
                                      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                          <div class="flex space-x-2">
                                              <a href="{{ route('trainings.show', $training) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                              @can('update', $training)
                                                  <a href="{{ route('trainings.edit', $training) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                              @endcan
                                              @can('delete', $training)
                                                  <form action="{{ route('trainings.destroy', $training) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this training?');">
                                                      @csrf
                                                      @method('DELETE')
                                                      <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                                  </form>
                                              @endcan
                                          </div>
                                      </td>
                                  </tr>
                              @empty
                                  <tr>
                                      <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                          {{ __('No trainings found.') }}
                                      </td>
                                  </tr>
                              @endforelse
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
      </div>
  </div>
</x-app-layout>