<x-data-table.table class="max-w-screen-xl" title="Rotations" itemType="rotation" :pagination="$rotations" :sortOptions="$sort_options" :filterOptions="$filter_options" minWidth="1280" :search="false">
    <x-slot name="actions">
        <button class="ml-4" wire:click="makeDraft()">Make draft</button>
        <button class="ml-4" wire:click="publish()">Publish</button>
        <button class="ml-4" wire:click="disable()">Disable</button>
        <button class="ml-4" wire:click="archive()">Archive</button>
    </x-slot>

    @if((count($rotations) == 0) && !$filtering)
        <x-data-table.data-row :selectable="false" bgClass="bg-white" id="">
            <td class="whitespace-nowrap" colspan="6">There are no rotations currently.</td>
        </x-data-table.data-row>
    @elseif((count($rotations) == 0) && $filtering)
        <x-data-table.data-row :selectable="false" bgClass="bg-white" id="">
            <td class="whitespace-nowrap" colspan="6">No rotations matched.</td>
        </x-data-table.data-row>
    @else
        <x-slot name="header">
            <td class="px-2 whitespace-nowrap">Preceptor</td>
            <td class="px-2 whitespace-nowrap">Hospital</td>
            <td class="px-2 whitespace-nowrap">City, State, and Zip</td>
            <td class="px-2 whitespace-nowrap">Status</td>
            <td class="px-2 whitespace-nowrap text-right">Price per week</td>
            <td class="px-2 whitespace-nowrap pl-8"></td>
        </x-slot>
    @endif

    @foreach($rotations as $i => $rotation)
    <x-data-table.data-row :selectable="true" :bgClass="$i%2==0?'bg-white':'bg-gray-50'" :id="$rotation->id">
        <td class="px-2 whitespace-nowrap">{{ $rotation->preceptor_name }}</td>
        <td class="px-2 whitespace-nowrap">{{ $rotation->hospital_name }}</td>
        <td class="px-2 whitespace-nowrap">{{ $rotation->city }}, {{ $rotation->state }}, {{ $rotation->zipcode }}</td>
        <td class="px-2 whitespace-nowrap capitalize">{{ $rotation->status }}</td>
        <td class="px-2 whitespace-nowrap text-right ">${{ $rotation->price_per_week_in_cents/100 }}</td>
        <td class="px-2 whitespace-nowrap pl-8"><a class="font-bold" href="{{ route('admin-rotation-view',['rotation' => $rotation]) }}">View</a></td>
    </x-data-table.data-row>
    @endforeach
</x-data-table.table>
