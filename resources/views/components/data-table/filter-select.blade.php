@props(['name','id','options'])

<div>
    <label class="block font-bold" for="{{ $id }}">{{ $name }}</label>
    <select id="{{ $id }}" class="mt-2 md:mb-0 mb-4 w-full" wire:model="filters.{{$id}}">
        <option value="default">All</option>
        @foreach ($options as  $key => $item)
        <option value="{{ $key }}">{{ $item }}</option>
        @endforeach
    </select>
</div>