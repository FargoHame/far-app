<x-app-layout>
    <!-- Metadata -->
    @section ('title', 'Find a Rotation')
    @section ('description', 'Welcome to Find a Rotation')

    <x-filter/>
    <div class="bg-white">
        <div class="mx-auto w-full max-w-7xl px-4 pt-5 pb-8">
            <div class="grid md:grid-cols-3 lg:grid-cols-4 gap-5 box-container">
                @foreach ($rotations as $rotation )
                    <div class="opp-box">
                        <a href="{{ route('view-rotation',['rotation' => $rotation]) }}">
                            <div class="box" 
                                @if (count($rotation->images) > 0)
                                    style="background-image: url({{$rotation->images[0]->path}})">
                                @else
                                    style="background-image: url( {{ \App\Models\User::where(['id' => $rotation->preceptor_user_id])->firstOrFail()->photo() }})">
                                @endif
                                <div class="content flex justify-end flex-col h-full p-2">
                                    <h4>{{$rotation->preceptor_name}}, {{ $rotation->hospital_name }}</h4>
                                    <ul class="flex flex-wrap">
                                        @foreach($rotation->specialties as $specialty)
                                            <li>{{ $specialty->name }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="price">${{ number_format($rotation->price_per_week_in_cents/100,0) }}</div>
                            <div class="location flex"><x-icons.location/> {{ $rotation->city }}, {{ $rotation->state }}</div>
                        </a>
                    </div>
                @endforeach
            </div>
            {{--  <div class="flex justify-center mt-8">
                <button class="btn btn-gray pr-8 pl-8">Load more results</button>
            </div>  --}}
        </div>
        <div class="prefooter pt-8 pb-8">
            <div class="mx-auto w-full max-w-7xl px-4 pt-5">
                <h2>"Didn't find what you were looking for?"</h2>
                {{--  <button class="btn btn-green pl-6 pr-6 mb-3" style="font-weight: 400;font-size: 14px">Contact our support team</button>  --}}
                <p>
                    email us <br/>
                    <a href="mailto:support@findarotation.com" class="font-bold">support@findarotation.com</a>
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
