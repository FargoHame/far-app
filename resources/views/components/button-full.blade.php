@props(['type'])
<button {{ $attributes->merge(['type' => isset($type) ? $type :'submit']) }} class="w-full px-6 py-2 bg-far-green-dark hover:opacity-75 btn">
    {{ $slot }}
</button>