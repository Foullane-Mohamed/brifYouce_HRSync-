<div class="org-chart-node">
  <div class="font-bold">{{ $node['name'] }}</div>
  <div class="text-sm text-gray-600">{{ $node['position'] }}</div>
  <div class="text-xs text-gray-500">{{ $node['department'] }}</div>
  <div class="text-xs text-blue-600">{{ $node['email'] }}</div>
  <div class="mt-2">
      <a href="{{ route('employees.show', $node['id']) }}" class="text-xs text-indigo-600 hover:text-indigo-900">
          Voir profil
      </a>
  </div>
</div>

@if(count($node['children']) > 0)
  <div class="org-chart-children">
      @foreach($node['children'] as $child)
          <div class="org-chart-node-container">
              @include('livewire.org-chart-node', ['node' => $child])
          </div>
      @endforeach
  </div>
@endif