<x-app-layout>
    <!-- Metadata -->
    @section ('title', 'Find a Rotation')
    @section ('description', 'View rotation')

    <link rel="stylesheet" href="{{ asset('css/lightbox.min.css') }}">

    <!-- Code -->
    <div class="mx-auto w-full max-w-7xl px-4 pt-5">
        <div class="md:flex justify-between">
            <h1 class="text-3xl font-bold mb-6">Rotation Detail</h1>
            <div class=" mb-4 flex justify-end">
                <a href="{{ url()->previous() }}" class="px-6 py-2 rounded-md btn-green text-white md:w-auto w-full text-center">Back</a>
            </div>
        </div>
        <div class="p-8 mb-6 card-application">
            <div class="md:flex justify-between">
                <div class="md:flex md:flex-row md:items-center mb-4">
                    <div class="flex flex-col mr-4">
                        <img class="rounded-full user-pict" src="{{ \App\Models\User::where(['id' => $rotation->preceptor_user_id])->firstOrFail()->photo() }}" />
                    </div>
                    <div class="md:ml-4">
                        <p class="name font-semibold mb-1">{{ $rotation->preceptor_name }}</p>
                        <p class="mb-2 txt">
                            {{ $rotation->specialtyNames() }}
                            {{ $rotation->hospital_name }}
                            {{ $rotation->city }}, {{ $rotation->state }}
                        </p>
                    </div>
                </div>
                <div>
                    <p class="font-semibold text-lg">Week<br/> <span class="green-font">$ {{ $rotation->price_per_week_in_cents/100 }}</span></p>
                </div>
            </div>
            <div class="desc pb-3 mb-3">
                <p><b>Description</b></p>
                <p> <?php echo $rotation->description ?> </p>
            </div>
            @if (count($rotation->images) > 0)
                <div class="desc pb-3 mb-3">
                    <p class="mt-3 mb-3"><b>Attached files</b></p>
                    <div class="flex">
                        @foreach($rotation->images as $image)
                        <a target="_blank" href="{{ $image->path }}" data-lightbox="images" data-title="">
                            <img class="grid-col block" src="{{ $image->path }}" />
                        </a>
                        @endforeach
                    </div>
                </div>
            @endif
            @if (count($rotation->file_types) > 0)
                <div class="">
                    <div class="flex md:flex-row flex-col mt-2">
                        <div class="">
                        <p class="mb-3"><b>Documents required</b></p>
                        <ul>
                            @foreach($rotation->file_types as $fileType)
                            <li><p><x-icons.clip/></p><span></span><p>{{ $fileType->name }}</p></li>
                            @endforeach
                        </ul>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        @if (count($rotation->applications) > 0)
        <!-- Desktop view -->
        <div class="md:block hidden mb-4">
            <h1 class="text-3xl font-bold mb-6">Applications</h1>
            @php
                $applications = array_reverse($rotation->applications->all());
            @endphp
            @foreach($applications as $i => $application)
                @if ($application->rotation_slots[0]->starts_at > now())
                <div class="grid grid-cols-7 grid-flow-col gap-5 justify-between mb-5">
                    <div class="flex flex-col col-span-1">
                        <span class="gray-font font-bold">Student</span>
                        <b>{{ $application->student->name() }}</b>
                    </div>
                    <div class="flex flex-col col-span-2">
                        <span class="gray-font font-bold">Weeks</span>
                        <ol>
                            @foreach($application->rotation_slots as $availability)
                                <li><b>{{ $availability->starts_at->format('M d, Y') }} - {{ $availability->starts_at->copy()->addDays(6)->format('M d, Y') }}</b></li>
                            @endforeach
                        </ol>
                    </div>
                    <div class="flex flex-col col-span-1">
                        <span class="gray-font font-bold">Total weeks</span>
                        <b>{{ $application->rotation_slots()->count() }}</b>
                    </div>
                    <div class="flex flex-col col-span-1">
                        <span class="gray-font font-bold">Total value</span>
                        <b>${{ ($application->rotation->price_per_week_in_cents * $application->rotation_slots()->count())/100 }}</b>
                    </div>
                    <div class="flex flex-col col-span-1">
                        <span class="gray-font font-bold">Status</span>
                        <b>{{ $application->status }}</b>
                    </div>
                    <div class="flex flex-col items-center justify-center col-span-1">
                        <a class="btn-link-green" style="width: 100px" href="{{ route('preceptor-application-view',['application' => $application]) }}">View</a>
                    </div>
                </div>
                @endif

            @endforeach
        </div>

        <!-- Mobile view -->
        <div class="md:hidden card-application mb-4">
            @foreach($rotation->applications as $application)
                <div class="px-4 py-2 cursor-pointer" x-data="{ open: false }" @click="open = !open">
                    <div class="absolute right-6 text-2xl h-8 w-8" x-show="!open">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
                        </svg>
                    </div>
                    <div class="absolute right-6 text-2xl h-8 w-8" x-show="open">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>

                    <div>
                        <span class="gray-font font-bold">Student</span>
                        <b>{{ $application->student->name() }}</b>
                    </div>
                    <div class="mt-2">
                        <span class="gray-font font-bold">Total weeks</span>
                        <b>{{ $application->rotation_slots()->count() }}</b>
                    </div>
                    <div class="mt-2">
                        <span class="gray-font font-bold">Total value</span>
                        <b>${{ ($application->rotation->price_per_week_in_cents * $application->rotation_slots()->count())/100 }}</b>
                    </div>
                    <div class="mt-2">
                        <span class="gray-font font-bold">Status</span>
                        <b class="capitalize">{{ $application->status }}</b>
                    </div>

                    <div class="mt-2" x-bind:class="! open ? 'hidden' : ''">
                        <span class="gray-font font-bold">Weeks</span>
                        <ol>
                            @foreach($application->rotation_slots as $availability)
                                <li><b>{{ $availability->starts_at->format('M d, Y') }} - {{ $availability->starts_at->copy()->addDays(6)->format('M d, Y') }}</b></li>
                            @endforeach
                        </ol>
                    </div>

                    <div class="mt-4" x-bind:class="! open ? 'hidden' : ''">
                        <a class="btn-link-green" href="{{ route('preceptor-application-view',['application' => $application]) }}">View application</a>
                    </div>
                </div>
            @endforeach
        </div>
        @else
            <p class="text-2xl font-semibold mb-1">Applications</p>
            <p class="mb-5">You haven’t received any applications yet.</p>
        @endif
    </div>

    @push('scripts')
    <script src="{{ asset('js/lightbox-plus-jquery.min.js') }}"></script>
    @endpush
</x-app-layout>
