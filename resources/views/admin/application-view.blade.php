<x-app-layout>
  @section ('title', "View application")

    <div class="max-w-screen-md mx-auto py-12 px-2">

        <div class="p-4 mb-6 bg-far-orange-light">
            <div class="flex md:flex-row md:items-center mb-4">
                <div class="flex flex-col mr-4">
                    <img class="md:w-64 md:h-64 w-32 h-32 rounded-full" src="{{ \App\Models\User::where(['id' => $rotation->preceptor_user_id])->firstOrFail()->photo() }}" />
                </div>
                <div class="md:ml-4">
                    <p class="text-3xl font-semibold mb-1">{{ $rotation->preceptor_name }}</p>
                    <p class="mb-2">{{ $rotation->specialtyNames() }}</p>
                    <p class="mb-0 text-xl">{{ $rotation->hospital_name }}</p>
                    <p class="mb-2">{{ $rotation->city }}, {{ $rotation->state }}</p>
                    <p class="font-semibold text-xl">${{ $rotation->price_per_week_in_cents/100 }}/week</p>
                </div>
            </div>

            <div class="flex md:flex-row flex-col md:mt-8">
                <div class="">
                    <p><b>Description</b></p>
                    <p><?php echo $rotation->description ?></p>
                    @if (count($rotation->images) > 0)
                    <div class="grid md:grid-cols-3 grid-cols-2 mt-4">
                        @foreach($rotation->images as $image)
                        <a target="_blank" href="{{ asset('storage/'.basename($image->path)) }}" data-lightbox="images" data-title="">
                            <img class="grid-col block" src="{{ asset('storage/'.basename($image->path)) }}" />
                        </a>
                        @endforeach
                    </div>
                    @endif
                </div>

                @if (count($rotation->file_types) > 0)
                <div class="md:ml-8 md:mt-0 mt-4 md:min-w-200">
                    <p><b>Documents required</b></p>
                    @foreach($rotation->file_types as $fileType)
                    <p>{{ $fileType->name }}</p>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        <div class="px-2">
            <p class="text-4xl mt-8 mb-4"><b>Student:</b> {{ $application->student->name() }}</p>

            <!-- Desktop -->
            <table class="md:block hidden w-1/2 mb-4">
                <tr>
                    <td class="pr-2 whitespace-nowrap font-bold">Weeks</td>
                    <td class="px-2 whitespace-nowrap font-bold text-right">Total weeks</td>
                    <td class="px-2 whitespace-nowrap font-bold text-right">Value</td>
                    <td class="px-2 whitespace-nowrap font-bold pl-8">Status</td>
                </tr>
                <tr>
                    <td class="pr-2 whitespace-nowrap">
                        <ol>
                        @foreach($application->rotation_slots as $availability)
                        <li>{{ $availability->starts_at->format('M d, Y') }} - {{ $availability->starts_at->copy()->addDays(6)->format('M d, Y') }}</li>
                        @endforeach
                        </ol>
                    </td>
                    <td class="px-2 whitespace-nowrap text-right">
                        {{ $application->rotation_slots->count() }}
                    </td>
                    <td class="px-2 whitespace-nowrap text-right">${{ ($rotation->price_per_week_in_cents * $application->rotation_slots->count())/100 }}</td>
                    <td class="px-2 whitespace-nowrap pl-8 capitalize">{{ $application->status }}</td>
                </tr>
            </table>

            <!-- Mobile -->
            <div class="md:hidden mb-4">
                <div class="mt-2">
                    <p class="font-semibold">Weeks</p>
                    <ol>
                        @foreach($application->rotation_slots as $availability)
                            <li>{{ $availability->starts_at->format('M d, Y') }} - {{ $availability->starts_at->copy()->addDays(6)->format('M d, Y') }}</li>
                        @endforeach
                    </ol>
                </div>
                <div class="mt-2">
                    <p class="font-semibold">Total weeks</p>
                    <p>{{ $application->rotation_slots()->count() }}</p>
                </div>
                <div class="mt-2">
                    <p class="font-semibold">Value</p>
                    <p>${{ ($rotation->price_per_week_in_cents * $application->rotation_slots->count())/100 }}</p>
                </div>
                <div class="mt-2">
                    <p class="font-semibold">Status</p>
                    <p class="capitalize">{{ $application->status }}</p>
                </div>
            </div>

            @if (count($application->files) > 0)
            <p class="text-xl mb-2 font-semibold">Documents</p>
            <table class="w-1/2">
                <tr>
                    <td class="pr-2 whitespace-nowrap font-bold">Name</td>
                    <td class="px-2 whitespace-nowrap font-bold">Provided on</td>
                    <td class="px-2 whitespace-nowrap font-bold"></td>
                </tr>
                @foreach($application->files as $file)
                <tr>
                    <td class="pr-2 py-1 whitespace-nowrap">{{ $file->filename }}</td>
                    <td class="px-2 whitespace-nowrap">{{ $file->created_at->format('M d, Y') }} ({{ $file->file_type_id == null ? 'Via message':'With application' }})</td>
                    <td class="px-2 whitespace-nowrap"><a class="font-semibold" href="{{ route('preceptor-file-download',['file' => $file]) }}">Download</a></td>
                </tr>
                @endforeach
            </table>
            @else
            <p class="text-xl mb-1 font-semibold">Documents</p>
            <p>This student hasn’t attached any documents.</p>
            @endif
        </div>

        <div class="mt-12 px-2">
            <p class="text-2xl mb-2 font-bold">Messages</p>

            @if (count($messages) > 0)
                @foreach($messages as $message)
                    <div class="mb-2 p-4 flex md:flex-row flex-col {{ $message->user->role == 'preceptor' ? 'bg-far-orange-light' : 'bg-far-green-light'}}">
                        <div class="md:w-320">
                            <b>{{ $message->user == Auth::user() ? 'You' : $message->user->name() }}</b>
                            <p class="text-sm">{{ Carbon\Carbon::parse($message->created_at)->toFormattedDateString() }} ({{ \Carbon\Carbon::parse($message->created_at)->diffForHumans() }})</p>
                        </div>
                        <p class="md:mt-0 mt-2">@php echo $message->message; @endphp</p>
                    </div>
                @endforeach
            @else
                <p>No messages exchanged yet.</p>
            @endif
        </div>

    </div>

</x-app-layout>
