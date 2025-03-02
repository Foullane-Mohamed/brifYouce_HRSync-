<x-app-layout>
  <x-slot name="header">
      <div class="flex justify-between items-center">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              {{ __('Career Developments') }}
          </h2>
          @can('create', App\Models\CareerDevelopment::class)
              <a href="{{ route('career-developments.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                  {{ __('Add Career Development') }}
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
                                      {{ __('Employee') }}
                                  </th>
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
                                      {{ __('Actions') }}
                                  </th>
                              </tr>
                          </thead>
                          <tbody class="bg-white divide-y divide-gray-200">
                              @forelse($careerDevelopments as $development)
                                  <tr>
                                      <td class="px-6 py-4 whitespace-nowrap">
                                          <div class="flex items-center">
                                              <div class="flex-shrink-0 h-10 w-10">
                                                  @if($development->employee->user->profile_photo_url)
                                                      <img class="h-10 w-10 rounded-full" src="{{ $development->employee->user->profile_photo_url }}" alt="{{ $development->employee->user->name }}">
                                                  @else
                                                      <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                          <span class="text-gray-500">{{ substr($development->employee->user->name, 0, 1) }}</span>
                                                      </div>
                                                  @endif
                                              </div>
                                              <div class="ml-4">
                                                  <div class="text-sm font-medium text-gray-900">
                                                      {{ $development->employee->user->name }}
                                                  </div>
                                                  <div class="text-sm text-gray-500">
                                                      {{ $development->employee->position ?: 'N/A' }}
                                                  </div>
                                              </div>
                                          </div>
                                      </td>
                                      <td class="px-6 py-4 whitespace-nowrap">
                                          <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                              @if($development->type == 'Promotion') bg-green-100 text-green-800 
                                              @elseif($development->type == 'Salary Increase') bg-blue-100 text-blue-800 
                                              @elseif($development->type == 'Position Change') bg-purple-100 text-purple-800 
                                              @else bg-gray-100 text-gray-800 @endif">
                                              {{ $development->type }}
                                          </span>
                                      </td>
                                      <td class="px-6 py-4 whitespace-nowrap">
                                          <div class="text-sm text-gray-900">{{ $development->date->format('M d, Y') }}</div>
                                      </td>
                                      <td class="px-6 py-4 whitespace-nowrap">
                                          <div class="text-sm text-gray-900">{{ $development->previous_value ?: 'N/A' }}</div>
                                      </td>
                                      <td class="px-6 py-4 whitespace-nowrap">
                                          <div class="text-sm text-gray-900">{{ $development->new_value ?: 'N/A' }}</div>
                                      </td>
                                      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                          <div class="flex space-x-2">
                                              <a href="{{ route('career-developments.show', $development) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                              @can('update', $development)
                                                  <a href="{{ route('career-developments.edit', $development) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                              @endcan
                                              @can('delete', $development)
                                                  <form action="{{ route('career-developments.destroy', $development) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this development record?');">
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
                                          {{ __('No career developments found.') }}
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