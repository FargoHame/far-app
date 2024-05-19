<x-app-layout>
    <!-- Metadata -->
    @section ('title', 'Find a Rotation')
    @section ('description', 'Search results')

    <!-- Code -->
    <div class="mx-auto w-full max-w-7xl px-4 pt-5">
        <x-filter/>
        @if(count($rotations) > 0)
            <div class="grid md:grid-cols-3 lg:grid-cols-4 gap-5 pt-8 pb-8">
                @foreach($rotations as $rotation)
                    <div class="opp-box">
                        <a href="{{ route('view-rotation',['rotation' => $rotation]) }}">
                            <div class="box" 
                                @if (count($rotation->images) > 0)
                                    style="background-image: url({{$rotation->images[0]->path}})">
                                @else
                                    style="background-image: url( {{ \App\Models\User::where(['id' => $rotation->preceptor_user_id])->firstOrFail()->photo() }})">
                                @endif
                                {{--  {{ $rotation->availabilty()->where('starts_at','>',\Carbon\Carbon::now())->orderBy('starts_at','ASC')->first()->starts_at->format('M d, Y') }}  --}}
                                {{--   <img class="w-24 h-24 rounded-full" src="/{{ \App\Models\User::where(['id' => $rotation->preceptor_user_id])->firstOrFail()->photo() }}" />  --}}
                                <div class="content flex justify-end flex-col h-full p-2">
                                    <h4>{{$rotation->preceptor_name}}, {{ $rotation->hospital_name }}</h4>
                                    <ul class="flex flex-wrap">
                                        @foreach($rotation->specialties as $specialty)
                                            <li>{{ $specialty->name }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="price flex justify-between items-center">${{ number_format($rotation->price_per_week_in_cents/100,0) }} <span class="text-sm">from: {{$rotation->availabilty()->first()->starts_at->format('M d, Y') }}</span></div>
                            <div class="location flex"><x-icons.location/> {{ $rotation->city }}, {{ $rotation->state }}</div>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="grid md:grid-cols-3 lg:grid-cols-4 gap-5 box-container"></div>
            <div class="w-full text-right mb-2">
                {{ $rotations->links('pagination::tailwind') }}
            </div>
        @else
            <div class="max-w-screen-lg mx-auto mt-6">
                <p>No rotations meet your search criteria.</p>
            </div>
        @endif
    </div>

    @push('scripts')
    <script >
        $(document).ready(function() {
            $(".js-range-slider").ionRangeSlider({
                skin: "round",
                type: "double",
                grid: true,
                min: 0,
                max: {{ config('rotation.max_rotation_price') }},
                from: {{ $price_min }},
                to: {{ $price_max }},
                prefix: "$"
            }
            );
        });
    </script>
    @endpush

</x-app-layout>
