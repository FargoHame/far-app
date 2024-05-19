@props(['name','id'])

<div>
    <label class="block font-bold" for="{{ $id }}">{{ $name }}</label>
    <input type="text" id="{{ $id }}" class="mt-2 md:mb-0 mb-4 w-full" wire:model="filters.{{$id}}">
</div>