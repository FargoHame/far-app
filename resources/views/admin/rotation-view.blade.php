<x-app-layout>
    <!-- Metadata -->
    @section ('title', 'Find a Rotation')
    @section ('description', 'View rotation')

    <link rel="stylesheet" href="{{ asset('css/lightbox.min.css') }}">

    <!-- Code -->
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
                <div class="md:ml-8 md:mt-0 mt-4 min-w-200">
                    <p><b>Documents required</b></p>
                    @foreach($rotation->file_types as $fileType)
                    <p>{{ $fileType->name }}</p>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        @if (count($rotation->applications) > 0)
        <!-- Desktop view -->
        <div class="md:block hidden mb-4">
            <p class="text-2xl font-semibold mb-4">Applications</p>
            <table class="w-full">
                <tr>
                    <td class="px-2 whitespace-nowrap font-bold">Student</td>
                    <td class="px-2 whitespace-nowrap font-bold">Weeks</td>
                    <td class="px-2 whitespace-nowrap font-bold text-right">Total weeks</td>
                    <td class="px-2 whitespace-nowrap font-bold text-right">Total value</td>
                    <td class="px-2 whitespace-nowrap font-bold pl-8">Status</td>
                    <td class="px-2 whitespace-nowrap font-bold"></td>
                </tr>
                @foreach($rotation->applications as $i => $application)
                <tr class="{{ $i%2==0?'bg-white':'bg-gray-50' }}">
                    <td class="px-2 whitespace-nowrap">{{ $application->student->name() }}</td>
                    <td class="p-2 whitespace-nowrap">
                        <ol>
                            @foreach($application->rotation_slots as $availability)
                                <li>{{ $availability->starts_at->format('M d, Y') }} - {{ $availability->starts_at->copy()->addDays(6)->format('M d, Y') }}</li>
                            @endforeach
                        </ol>
                    </td>
                    <td class="px-2 whitespace-nowrap text-right">{{ $application->rotation_slots()->count() }}</td>
                    <td class="px-2 whitespace-nowrap text-right">${{ ($application->rotation->price_per_week_in_cents * $application->rotation_slots()->count())/100 }}</td>
                    <td class="px-2 whitespace-nowrap pl-8 capitalize">{{ $application->status }}</td>
                    <td class="px-2 whitespace-nowrap"><a class="font-semibold" href="{{ route('admin-application-view',['application' => $application]) }}">View</a></td>
                </tr>
                @endforeach
            </table>
        </div>

        <!-- Mobile view -->
        <div class="md:hidden">
            @foreach($rotation->applications as $application)
                <div class="border px-4 py-2 mb-4 cursor-pointer" x-data="{ open: false }" @click="open = !open">
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
                        <p class="font-semibold">Student</p>
                        <p>{{ $application->student->name() }}</p>
                    </div>
                    <div class="mt-2">
                        <p class="font-semibold">Total weeks</p>
                        <p>{{ $application->rotation_slots()->count() }}</p>
                    </div>
                    <div class="mt-2">
                        <p class="font-semibold">Total value</p>
                        <p>${{ ($application->rotation->price_per_week_in_cents * $application->rotation_slots()->count())/100 }}</p>
                    </div>
                    <div class="mt-2">
                        <p class="font-semibold">Status</p>
                        <p class="capitalize">{{ $application->status }}</p>
                    </div>

                    <div class="mt-2" x-bind:class="! open ? 'hidden' : ''">
                        <p class="font-semibold">Weeks</p>
                        <ol>
                            @foreach($application->rotation_slots as $availability)
                                <li>{{ $availability->starts_at->format('M d, Y') }} - {{ $availability->starts_at->copy()->addDays(6)->format('M d, Y') }}</li>
                            @endforeach
                        </ol>
                    </div>

                    <div class="mt-4" x-bind:class="! open ? 'hidden' : ''">
                        <a class="paymentinline-block font-semibold mr-3 text-far-green-dark" href="{{ route('admin-application-view',['application' => $application]) }}">View application</a>
                    </div>
                </div>
            @endforeach
        </div>
        @else
            <p class="text-2xl font-semibold mb-1">Applications</p>
            <p>This rotation hasn't received any applications yet.</p>
        @endif
    </div>

    @push('scripts')
    <script src="{{ asset('js/lightbox-plus-jquery.min.js') }}"></script>
    @endpush
</x-app-layout>
