<x-data-table.table class="max-w-screen-xl" title="Preceptors" itemType="preceptor" :pagination="$preceptors" :sortOptions="$sort_options" :filterOptions="$filter_options" minWidth="1280" :search="true">
    <x-slot name="actions">
        <button class="ml-4" wire:click="activate()">Activate</button>
        <button class="ml-4" wire:click="inactivate()">Inactivate</button>
        <button class="ml-4" wire:click="suspend()">Suspend</button>
    </x-slot>

    @if((count($preceptors) == 0) && !$filtering)
        <x-data-table.data-row :selectable="false" bgClass="bg-white" id="">
            <td class="whitespace-nowrap" colspan="6">There are no preceptors currently.</td>
        </x-data-table.data-row>
    @elseif((count($preceptors) == 0) && $filtering)
        <x-data-table.data-row :selectable="false" bgClass="bg-white" id="">
            <td class="whitespace-nowrap" colspan="6">No preceptors matched.</td>
        </x-data-table.data-row>
    @else
        <x-slot name="header">
            <td class="px-2 whitespace-nowrap">First name</td>
            <td class="px-2 whitespace-nowrap">Last name</td>
            <td class="px-2 whitespace-nowrap">Email</td>
            <td class="px-2 whitespace-nowrap">Status</td>
            <td class="px-2 whitespace-nowrap text-right">Rotations</td>
            <td class="px-2 whitespace-nowrap pl-8">Created</td>
            <td class="px-2 whitespace-nowrap">Last login</td>
            <td class="px-2 whitespace-nowrap"></td>
        </x-slot>
    @endif

    @foreach($preceptors as $i => $user)
    <x-data-table.data-row :selectable="true" :bgClass="$i%2==0?'bg-white':'bg-gray-50'" :id="$user->id">
        <td class="px-2 whitespace-nowrap">{{ $user->first_name }}</td>
        <td class="px-2 whitespace-nowrap">{{ $user->last_name }}</td>
        <td class="px-2 whitespace-nowrap">{{ $user->email }}</td>
        <td class="px-2 whitespace-nowrap capitalize">{{ $user->email_verified_at ? $user->status : 'Not verified' }}</td>
        <td class="px-2 whitespace-nowrap text-right">{{ \App\Models\Rotation::where(['preceptor_user_id' => $user->id])->count() }}</td>
        <td class="px-2 whitespace-nowrap pl-8">{{ \Carbon\Carbon::parse($user->created_at)->diffForHumans() }}</td>
        <td class="px-2 whitespace-nowrap">{{ \Carbon\Carbon::parse($user->last_login_at)->diffForHumans() }}</td>
        <td class="px-2 whitespace-nowrap"><a class="font-bold" href="{{ route('admin-user-edit', ['user' => $user]) }}">Edit</a></td>
    </x-data-table.data-row>
    @endforeach
</x-data-table.table>
