<x-data-table.table class="max-w-screen-xl" title="Applications" itemType="application" :pagination="$applications" :sortOptions="$sort_options" :filterOptions="$filter_options" minWidth="1280" :search="false">
    <x-slot name="actions">
        <button class="ml-4" wire:click="markAsPending()">Mark as pending</button>
        <button class="ml-4" wire:click="markAsAccepted()">Mark as accepted</button>
        <button class="ml-4" wire:click="markAsPaid()">Mark as paid</button>
        <button class="ml-4" wire:click="markAsRejected()">Mark as rejected</button>
        <button class="ml-4" wire:click="markAsWithdrawn()">Mark as withdrawn</button>
    </x-slot>

    @if((count($applications) == 0) && !$filtering)
        <x-data-table.data-row :selectable="false" bgClass="bg-white" id="">
            <td class="whitespace-nowrap" colspan="6">There are no applications currently.</td>
        </x-data-table.data-row>
    @elseif((count($applications) == 0) && $filtering)
        <x-data-table.data-row :selectable="false" bgClass="bg-white" id="">
            <td class="whitespace-nowrap" colspan="6">No applications matched.</td>
        </x-data-table.data-row>
    @else
        <x-slot name="header">
            <td class="px-2 whitespace-nowrap">Rotation</td>
            <td class="px-2 whitespace-nowrap">Student</td>
            <td class="px-2 whitespace-nowrap">Weeks</td>
            <td class="px-2 whitespace-nowrap">Applied</td>
            <td class="px-2 whitespace-nowrap">Status</td>
            <td class="px-2 whitespace-nowrap text-right">Messages</td>
            <td class="px-2 whitespace-nowrap pl-8"></td>
        </x-slot>
    @endif

    @foreach($applications as $i => $application)
    <x-data-table.data-row :selectable="true" :bgClass="$i%2==0?'bg-white':'bg-gray-50'" :id="$application->id">
        <td class="px-2 whitespace-nowrap">{{ $application->rotation->preceptor_name }}</td>
        <td class="px-2 whitespace-nowrap">{{ $application->student->first_name . ' ' . $application->student->last_name }}</td>
        <td class="p-2 whitespace-nowrap">
            <ol class="list-decimal list-inside">
            @foreach($application->rotation_slots as $availability)
                <li>{{ $availability->starts_at->format('M d, Y') }} - {{ $availability->starts_at->copy()->addDays(6)->format('M d, Y') }}</li>
            @endforeach
            </ol>            
        </td>
        <td class="px-2 whitespace-nowrap">{{ Carbon\Carbon::parse($application->created_at)->toFormattedDateString() }} ({{ \Carbon\Carbon::parse($application->created_at)->diffForHumans() }})</td>
        <td class="px-2 whitespace-nowrap capitalize">{{ $application->status }}</td>
        <td class="px-2 whitespace-nowrap text-right ">{{ $application->messages->count() }}</td>
        <td class="px-2 whitespace-nowrap pl-8"><a class="font-bold" href="{{ route('admin-application-view',['application' => $application]) }}">View</a></td>
    </x-data-table.data-row>
    @endforeach
</x-data-table.table>
