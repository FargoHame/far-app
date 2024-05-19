<x-data-table.table class="max-w-screen-lg" title="Payments" itemType="payment" :pagination="$payments" :sortOptions="$sort_options" :filterOptions="$filter_options" minWidth="1280" :search="false">
    <x-slot name="actions">
        <button class="ml-4" wire:click="markDistributed()">Mark as distrubted</button>
        <button class="ml-4" wire:click="sendPayment()">Send to Gigwage</button>
    </x-slot>

    @if((count($payments) == 0) && !$filtering)
        <x-data-table.data-row :selectable="false" bgClass="bg-white" id="">
            <td class="whitespace-nowrap" colspan="6">There are no payments currently.</td>
        </x-data-table.data-row>
    @elseif((count($payments) == 0) && $filtering)
        <x-data-table.data-row :selectable="false" bgClass="bg-white" id="">
            <td class="whitespace-nowrap" colspan="6">No payments matched.</td>
        </x-data-table.data-row>
    @else
        <x-slot name="header">
            <td class="px-2 whitespace-nowrap">Rotation</td>
            <td class="px-2 whitespace-nowrap">Student</td>
            <td class="px-2 whitespace-nowrap">Created</td>
            <td class="px-2 whitespace-nowrap text-right">Value</td>
            <td class="px-2 whitespace-nowrap pl-8">Status</td>
            <td class="px-2 whitespace-nowrap">Distribution</td>
            <!--<td class="px-2 whitespace-nowrap pl-8"></td>-->
        </x-slot>
    @endif

    @foreach($payments as $i => $payment)
    <x-data-table.data-row :selectable="true" :bgClass="$i%2==0?'bg-white':'bg-gray-50'" :id="$payment->id">
        <td class="px-2 whitespace-nowrap">{{ $payment->application->rotation->preceptor_name }}</td>
        <td class="px-2 whitespace-nowrap">{{ $payment->application->student->name() }}</td>
        <td class="px-2 whitespace-nowrap">{{ Carbon\Carbon::parse($payment->created_at)->toFormattedDateString() }} ({{ \Carbon\Carbon::parse($payment->created_at)->diffForHumans() }})</td>
        <td class="px-2 whitespace-nowrap text-right">${{ number_format($payment->application->rotation_slots->count() * $payment->application->rotation->price_per_week_in_cents / 100, 0) }}</td>
        <td class="px-2 whitespace-nowrap capitalize pl-8">{{ $payment->status }}</td>
        <td class="px-2 whitespace-nowrap capitalize">{{ $payment->distribution_status }}</td>
        <!--<td class="px-2 whitespace-nowrap pl-8"><a class="font-bold" href="#">View</a></td>-->
    </x-data-table.data-row>
    @endforeach
</x-data-table.table>
