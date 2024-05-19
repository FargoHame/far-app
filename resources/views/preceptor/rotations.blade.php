<x-app-layout>
    @section ('title', "View rotations")

    <div class="mx-auto w-full max-w-7xl px-4 pt-5">
        <div class="md:flex justify-between">
            <h1 class="text-3xl font-bold">Rotations</h1>
            <div class=" mb-4 flex justify-end">
                <a href="{{ route('preceptor-rotation-edit') }}" class="px-6 py-2 rounded-md btn-green text-white md:w-auto w-full text-center">Add new rotation</a>
            </div>
        </div>
        <div class="border-b flex justify-between border-b-gray-300 mb-5" >
            <div class="flex header">
                <a href="{{route('preceptor-rotations')}}" data-tab="tabs-1" class="font-medium text-xl pb-3 mr-5 @if($status == '') border-b-4 border-black @else opacity-30 @endif">Actives</a>
                <a href="{{route('preceptor-rotations')}}?status=archived" data-tab="tabs-2" class="font-medium text-xl pb-3 mr-5  @if($status == 'archived') border-b-4 border-black @else opacity-30 @endif">Archives</a>
            </div>
        </div>

        @if (count($rotations) > 0)
        <!-- Desktop view -->
        <div class="md:block hidden">
            @foreach($rotations as $rotation)
            @php
            $pending = $rotation->applications()->where(['status' => 'pending'])->count()
            @endphp
            <div class="rotations relative">
                @if ($pending > 0)
                <a href="{{ route('preceptor-rotation-view', ['rotation' => $rotation]) }}" class="absolute -top-3 -left-3 w-12 h-12 rounded-full text-white flex justify-center items-center" style="background: #3ab8b9">
                    <span class="fa fa-bell relative">
                        <h4 class="absolute text-xs -top-1 -right-1">{{$pending}}</h4>
                    </span>
                </a>
                @endif
                <div class="header flex justify-between">
                    <h4>{{$rotation->hospital_name}}</h4>
                    <div class="flex justify-between items-start">
                        <a href="{{ route('preceptor-rotation-calendar',['rotation' => $rotation]) }}" class="font-semibold mr-5 flex items-center"><x-icons.calendar /> Calendar</a>
                        <a href="{{ route('preceptor-rotation-view', ['rotation' => $rotation]) }}" class="font-semibold mr-5 flex items-center"><x-icons.eye /> View</a>
                        <a href="{{ route('preceptor-rotation-edit',['rotation' => $rotation]) }}" class="font-semibold mr-5 flex items-center"><x-icons.pencil /> Edit</a>
                        @if ($rotation->status=='draft')
                        <a href="{{ route('preceptor-rotation-change-status',['rotation' => $rotation, 'status' => 'published']) }}" class="font-semibold mr-5 text-far-green-dark flex items-center"><x-icons.setting /> Publish</a>
                        @elseif ($rotation->status != 'disabled')
                        <a href="{{ route('preceptor-rotation-change-status',['rotation' => $rotation, 'status' => 'disabled']) }}" class="font-semibold mr-5 flex items-center" style="color:#ff2d0f"> <x-icons.close color="#ff2d0f" /> Disable</a>
                        @endif
                        @if ($rotation->status=='disabled')
                        <a href="{{ route('preceptor-rotation-change-status',['rotation' => $rotation, 'status' => 'published']) }}" class="font-semibold mr-5 flex items-center"><x-icons.setting /> Enable</a>
                        <a href="{{ route('preceptor-rotation-change-status',['rotation' => $rotation, 'status' => 'archived']) }}" class="font-semibold mr-5 flex items-center"><x-icons.setting /> Archive</a>
                        @endif
                    </div>
                </div>
                <div class="grid grid-cols-6 grid-flow-col gap-5 justify-between body">
                    <div class="flex flex-col col-span-1">
                        <span>Specialty</span>
                        <b>{{$rotation->specialtyNames()}}</b>
                    </div>
                    <div class="flex flex-col col-span-1">
                        <span>Price per week</span>
                        <b>$ {{ number_format($rotation->price_per_week_in_cents/100,0) }}</b>
                    </div>
                    <div class="flex flex-col col-span-1">
                        <span>Confirmed</span>
                        <b>{{$rotation->applications()->where(['status' => 'paid'])->count()}}</b>
                    </div>
                    <div class="flex flex-col col-span-1">
                        <span>Accepted</span>
                        <b>{{$rotation->applications()->where(['status' => 'accepted'])->count()}}</b>
                    </div>
                    <div class="flex flex-col col-span-1">
                        <span>Pending</span>
                        <b>{{$pending}}</b>
                    </div>
                    <div class="flex flex-col col-span-1">
                        <span>Status</span>
                        <b>{{$rotation->status}}</b>
                    </div>
                </div>
            </div>
            @endforeach

            {{ $rotations->links() }}
        </div>

        <!-- Mobile view -->
        <div class="md:hidden">
            @foreach($rotations as $rotation)
            @php
            $pending = $rotation->applications()->where(['status' => 'pending'])->count()
            @endphp
            <div class="border px-4 py-2 mb-4 cursor-pointer rotations relative" x-data="{ open: false }" @click="open = !open">
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
                @if ($pending > 0)
                <a href="{{ route('preceptor-rotation-view', ['rotation' => $rotation]) }}" class="absolute -top-3 -left-3 w-10 h-10 rounded-full text-white flex justify-center items-center" style="background: #3ab8b9">
                    <span class="fa fa-bell relative">
                        <h4 class="absolute text-xs -top-1 -right-1">{{$pending}}</h4>
                    </span>
                </a>
                @endif
                <div class="header">
                    <h4>{{$rotation->hospital_name}}</h4>
                </div>
                <div class="body">
                    <div class="flex flex-col">
                        <span>Specialty</span>
                        <b>{{$rotation->specialtyNames()}}</b>
                    </div>
                    <div class="flex flex-col">
                        <span>Price per week</span>
                        <b>${{ number_format($rotation->price_per_week_in_cents/100,0) }}</b>
                    </div>
                    <div class="flex flex-col">
                        <span>Status</span>
                        <b class="{{ ($rotation->status=='draft') ? 'red-font' : '' }}">{{$rotation->status}}</b>
                    </div>
                    <div class="flex flex-col" x-bind:class="! open ? 'hidden' : ''">
                        <span>Confirmed</span>
                        <b>{{ $rotation->applications()->where(['status' => 'paid'])->count() }}</b>
                    </div>
                    <div class="flex flex-col" x-bind:class="! open ? 'hidden' : ''">
                        <span>Pending</span>
                        <b>{{ $pending }}</b>
                    </div>
                </div>
                <div class="flex justify-between items-start header" x-bind:class="! open ? 'hidden' : ''">
                    <a href="{{ route('preceptor-rotation-calendar',['rotation' => $rotation]) }}" class="font-semibold mr-5 flex items-center"><x-icons.calendar /> Calendar</a>
                    <a href="{{ route('preceptor-rotation-view', ['rotation' => $rotation]) }}" class="font-semibold mr-5 flex items-center"><x-icons.eye /> View</a>
                </div>
                <div class="flex justify-between items-start header" x-bind:class="! open ? 'hidden' : ''">
                    <a href="{{ route('preceptor-rotation-edit',['rotation' => $rotation]) }}" class="font-semibold mr-5 flex items-center"><x-icons.pencil /> Edit</a>
                    @if ($rotation->status=='draft')
                    <a href="{{ route('preceptor-rotation-change-status',['rotation' => $rotation, 'status' => 'published']) }}" class="font-semibold mr-5 text-far-green-dark flex items-center"><x-icons.setting />Publish</a>
                    @elseif ($rotation->status != 'disabled')
                    <a href="{{ route('preceptor-rotation-change-status',['rotation' => $rotation, 'status' => 'disabled']) }}" class="font-semibold mr-5 flex items-center" style="color:#ff2d0f"> <x-icons.close color="#ff2d0f" /> Disable</a>
                    @endif
                    @if ($rotation->status=='disabled')
                    <a href="{{ route('preceptor-rotation-change-status',['rotation' => $rotation, 'status' => 'published']) }}" class="font-semibold mr-5 flex items-center"><x-icons.setting /> Enable</a>
                    <a href="{{ route('preceptor-rotation-change-status',['rotation' => $rotation, 'status' => 'archived']) }}" class="font-semibold mr-5 flex items-center"><x-icons.setting /> Archive</a>
                    @endif
                </div>
            </div>
            @endforeach

            {{ $rotations->links() }}
        </div>
        @else
        <p>You haven’t added any rotations yet.</p>
        @endif
    </div>
</x-app-layout>