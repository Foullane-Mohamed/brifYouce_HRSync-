<x-app-layout>
  <x-slot name="header">
      <div class="flex justify-between items-center">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              {{ __('Contracts') }}
          </h2>
          @can('create', App\Models\Contract::class)
              <a href="{{ route('contracts.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                  {{ __('Add Contract') }}
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
                                      {{ __('Start Date') }}
                                  </th>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                      {{ __('End Date') }}
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
                              @forelse($contracts as $contract)
                                  <tr>
                                      <td class="px-6 py-4 whitespace-nowrap">
                                          <div class="flex items-center">
                                              <div class="flex-shrink-0 h-10 w-10">
                                                  @if($contract->employee->user->profile_photo_url)
                                                      <img class="h-10 w-10 rounded-full" src="{{ $contract->employee->user->profile_photo_url }}" alt="{{ $contract->employee->user->name }}">
                                                  @else
                                                      <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                          <span class="text-gray-500">{{ substr($contract->employee->user->name, 0, 1) }}</span>
                                                      </div>
                                                  @endif
                                              </div>
                                              <div class="ml-4">
                                                  <div class="text-sm font-medium text-gray-900">
                                                      {{ $contract->employee->user->name }}
                                                  </div>
                                                  <div class="text-sm text-gray-500">
                                                      {{ $contract->employee->position ?: 'N/A' }}
                                                  </div>
                                              </div>
                                          </div>
                                      </td>
                                      <td class="px-6 py-4 whitespace-nowrap">
                                          <div class="text-sm text-gray-900">{{ $contract->type }}</div>
                                      </td>
                                      <td class="px-6 py-4 whitespace-nowrap">
                                          <div class="text-sm text-gray-900">{{ $contract->start_date->format('M d, Y') }}</div>
                                      </td>
                                      <td class="px-6 py-4 whitespace-nowrap">
                                          <div class="text-sm text-gray-900">{{ $contract->end_date ? $contract->end_date->format('M d, Y') : 'Indefinite' }}</div>
                                      </td>
                                      <td class="px-6 py-4 whitespace-nowrap">
                                          <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $contract->end_date && $contract->end_date < now() ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                              {{ $contract->end_date && $contract->end_date < now() ? 'Expired' : 'Active' }}
                                          </span>
                                      </td>
                                      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                          <div class="flex space-x-2">
                                              <a href="{{ route('contracts.show', $contract) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                              @can('update', $contract)
                                                  <a href="{{ route('contracts.edit', $contract) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                              @endcan
                                              @can('delete', $contract)
                                                  <form action="{{ route('contracts.destroy', $contract) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this contract?');">
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
                                          {{ __('No contracts found.') }}
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