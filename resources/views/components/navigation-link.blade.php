@props(['route','classes' => ''])

<a href="{{ route($route) }}" class="block mb-4 @if(Route::is($route)) font-semibold @endif {{ $classes }}">
  {{ $slot }}  
</a>