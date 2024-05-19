@props(['options'])
<select class="md:ml-4 md:mt-0 mt-3" wire:model="sort">
    <option value="default">Select sort order</option>
    @foreach ($options as  $key => $item)
    <option value="{{ $key }}">{{ $item }}</option>
    @endforeach
</select>