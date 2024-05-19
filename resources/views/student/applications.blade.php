<x-app-layout>
  @section ('title', "View applications")

  <div class="mb-5" x-data="{open:false, application:0}">
    <div class="mx-auto w-full max-w-7xl px-4 pt-5">
        <div class="pb-4 mb-4">
             <div class="md:flex items-center">
                <h1 class="text-3xl font-bold">My Applications</h1>
            </div>
        </div>

        <div class="absolute top-0 left-0 flex items-center justify-center w-full h-full z-50 rounded-xl" style="background-color: rgba(0,0,0,.5);" x-show="open" x-cloak>
            <div class="h-auto p-6 text-left bg-white rounded-lg shadow-xl max-w-md" @click.away="open = false">
                <p class="text-xl font-semibold text-center">
                    Are you sure you want to<br/> withdraw your application?
                </p>
                <div class="md:flex items-center justify-center content-end pt-4 text-center">
                    <a href="#" @click.prevent="open = false" class="rounded-md md:w-auto w-full min-w-100 font-semibold px-2 py-1 text-white mr-4" style="background: rgba(0, 0, 0, 0.3)">No</a>
                    <form action="{{ route('student-application-withdraw') }}" method="POST">
                        @csrf
                        <input type="hidden" name="application_id" value="" x-model="application" />
                        <button type="submit" class="rounded-md md:w-auto w-full min-w-100 font-semibold px-2 py-1 bg-green text-white">Yes</button>
                    </form>
                </div>
            </div>
        </div>      

        @if (count($applications) > 0)
            @foreach($applications as $application)
                <div class="rotations mb-4 lg:block hidden">
                    <div class="md:grid grid-cols-6 grid-flow-col gap-5 body">
                        <div class="flex flex-col col-span-1">
                            <span>Rotation</span>
                            <b>{{ $application->rotation->preceptor_name }}<br/>{{ $application->rotation->hospital_name }}</b>
                        </div>
                        <div class="flex flex-col col-span-1 justify-between">
                            <span>Weeks selected</span>
                            <ol class="list-decimal list-inside">
                                @foreach($application->rotation_slots as $availability)
                                <li><b>{{ $availability->starts_at->format('M d, Y') }} - {{ $availability->starts_at->copy()->addDays(6)->format('M d, Y') }}</b></li>
                                @endforeach
                            </ol>
                        </div>
                        <div class="flex flex-col col-span-1 items-center">
                            <span>Total weeks</span>
                            <b>{{ $application->rotation_slots->count() }}</b>
                        </div>
                        <div class="flex flex-col col-span-1 items-center">
                            <span>Msg</span>
                            <b>{{ $application->messages->count() }}</b>
                        </div>
                        <div class="flex flex-col col-span-1 items-center">
                            <span>Status</span>
                            <b>{{ $application->status }}</b>
                        </div>
                        <div class="col-span-1 items-center justify-center flex" style="border-left-color: rgb(165 165 165 / 40%);">
                            <div class="flex border-l justify-end pl-7 h-full">
                                <a class="font-bold flex items-center pr-5 text-sm" href="{{ route('student-application-view',['application' => $application]) }}"><x-icons.eye/> <p class="pl-2 green-font">View</p></a>
                                @if ($application->status=="pending" || $application->status=="accepted")
                                <a class="ml-2 font-bold flex items-center text-sm" href="#" @click.prevent="open = true; application={{ $application->id }}"><x-icons.close/> <p class="pl-2 green-font">Withdraw</p></a>
                                @else
                                <a class="ml-2 font-bold flex items-center text-sm" style="opacity:0;visibility: hidden" href="#"><x-icons.close color="transparent"/> <p class="pl-2 green-font" style="color:transparent">Withdraw</p></a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        <!-- Mobile view -->
        <div class="lg:hidden rotations mb-4">
            @foreach($applications as $application)
                <div class="py-2 cursor-pointer body" x-data="{ open: false }" @click="open = !open">
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
                        <span>Rotation</span>
                        <b>{{ $application->rotation->preceptor_name }}<br/>{{ $application->rotation->hospital_name }}</b>
                    </div>
                    <div class="mt-2">
                        <span>Total weeks</span>
                        <b>{{ $application->rotation_slots()->count() }}</b>
                    </div>
                    <div class="mt-2">
                        <span>Status</span>
                        <b class="capitalize">{{ $application->status }}</b>
                    </div>

                    <div class="mt-2" x-bind:class="! open ? 'hidden' : ''">
                        <span>Weeks</span>
                        <ol>
                            @foreach($application->rotation_slots as $availability)
                                <li><b>{{ $availability->starts_at->format('M d, Y') }} - {{ $availability->starts_at->copy()->addDays(6)->format('M d, Y') }}</b></li>
                            @endforeach
                        </ol>
                    </div>

                    <div class="mt-4 flex justify-between" x-bind:class="! open ? 'hidden' : ''">
                    <a class="font-bold flex items-center pr-5 text-sm" href="{{ route('student-application-view',['application' => $application]) }}"><x-icons.eye/><p class="pl-2 green-font">View</p></a>
                    @if ($application->status=="pending" || $application->status=="accepted")
                        <a class="font-bold flex items-center pr-5 text-sm" href="#"><x-icons.close/><p class="pl-2 green-font">Withdraw</p></a>
                    @endif
                    </div>
                </div>
            @endforeach

            {{ $applications->links() }}
        </div>
        @else
            <p>You haven’t applied for any rotations yet.</p>
        @endif
    </div>
  </div>

</x-app-layout>
