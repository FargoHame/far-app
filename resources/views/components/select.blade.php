@props(['disabled' => false, 'values', 'value' => ''])
<div class="select-field">
    <select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border rounded-sm border-gray-300 h-12 ring-0 focus:ring-0 focus:outline-none focus:border-far-green-dark px-2']) !!}>
        @foreach($values as $val => $text)
            <option value="{{ $val }}" {{ $val==$value ? 'selected' : '' }}>{{ $text }}</option>
        @endforeach
    </select>
    <x-icons.carot-down/>
</div>