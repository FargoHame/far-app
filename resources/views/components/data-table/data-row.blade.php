@props(['selectable' => true,'bgClass','id'])

@if ($selectable)
<tr 
    x-init="$watch('selected', value => $dispatch('selection-updated', { value: value })); $wire.on('selection-reset', () => {selected=false})" 
    x-data="{selected:false}" 
    x-bind:class="{'bg-gray-500':selected,'text-white':selected,'{{ $bgClass }}':!selected}">
    <td class="pt-3 pb-4 pl-4">
        <input type="checkbox" x-model="selected" wire:model.defer="selected.{{ $id }}" value="1" />
    </td>
@else
<tr class="{{ $bgClass ?? ''}}">
@endif
{{$slot}}
</tr>