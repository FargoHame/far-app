@props(['disabled' => false,'isPassword'=>false])
@if ($isPassword)
    <div class="password-field">
        <input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'rounded-sm border-gray-300 h-12 ring-0 focus:ring-0 focus:outline-none focus:border-far-green-dark px-2 password']) !!}>
        <x-icons.eye-icon/>
    </div>
@else
    <input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border rounded-sm border-gray-300 h-12 ring-0 focus:ring-0 focus:outline-none focus:border-far-green-dark px-2']) !!}>
@endif
