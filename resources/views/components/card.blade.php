<div {{ $attributes->merge(['class' => 'bg-white shadow rounded-lg overflow-hidden']) }}>
  @if (isset($header))
      <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
          {{ $header }}
      </div>
  @endif

  <div class="px-4 py-5 sm:p-6">
      {{ $slot }}
  </div>

  @if (isset($footer))
      <div class="px-4 py-4 border-t border-gray-200 sm:px-6">
          {{ $footer }}
      </div>
  @endif
</div>