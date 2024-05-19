<x-app-layout>
  @section ('title', "View application")

    <div class="mx-auto w-full max-w-7xl px-4 pt-5">
        <div class="p-8 mb-6 card-application">
            <div class="md:flex justify-between">
                <div class="md:flex md:flex-row md:items-center mb-4">
                    <div class="flex flex-col mr-4">
                        <img class="rounded-full user-pict" src="{{ \App\Models\User::where(['id' => $rotation->preceptor_user_id])->firstOrFail()->photo() }}" />
                    </div>
                    <div class="md:ml-4">
                        <p class="name font-semibold mb-1">{{ $rotation->preceptor_name }}</p>
                        <p class="mb-2 txt">{{ $rotation->specialtyNames() }} {{ $rotation->hospital_name }}, {{ $rotation->city }}, {{ $rotation->state }}</p>
                    </div>
                </div>
                <div>
                    <p class="font-semibold text-lg">Week<br/> <span class="green-font">$ {{ $rotation->price_per_week_in_cents/100 }}</span></p>
                </div>
            </div>
            <div class="desc pb-3 mb-3">
                <p><b>Description</b></p>
                <p class="gray-font text-sm"><?php echo $rotation->description ?></p>
            </div>
            <div class="desc pb-3 mb-3">
                <table class="md:block hidden w-1/2 mb-4">
                    <tr>
                        <td class="pr-2 gray-font whitespace-nowrap">Weeks</td>
                        <td class="px-2 whitespace-nowrap gray-font text-right">Total weeks</td>
                        <td class="px-2 whitespace-nowrap gray-font text-right">Value</td>
                        <td class="px-2 whitespace-nowrap gray-font pl-8">Status</td>
                    </tr>
                    <tr>
                        <td class="pr-2 whitespace-nowrap">
                            <ol>
                            @foreach($application->rotation_slots as $availability)
                            <li class="font-bold text-sm">{{ $availability->starts_at->format('M d, Y') }} - {{ $availability->starts_at->copy()->addDays(6)->format('M d, Y') }}</li>
                            @endforeach
                            </ol>
                        </td>
                        <td class="px-2 whitespace-nowrap text-left font-bold text-sm">
                            {{ $application->rotation_slots->count() }}
                        </td>
                        <td class="px-2 whitespace-nowrap text-left font-bold text-sm">${{ $price }}</td>
                        <td class="px-2 whitespace-nowrap pl-8 capitalize font-bold text-sm">{{ $application->status }}</td>
                    </tr>
                </table>

                <!-- Mobile -->
                <div class="md:hidden mb-4">
                    <div class="mt-2">
                        <p class="gray-font">Weeks</p>
                        <ol>
                            @foreach($application->rotation_slots as $availability)
                                <li class="font-bold">{{ $availability->starts_at->format('M d, Y') }} - {{ $availability->starts_at->copy()->addDays(6)->format('M d, Y') }}</li>
                            @endforeach
                        </ol>
                    </div>
                    <div class="mt-2">
                        <p class="gray-font">Total weeks</p>
                        <p class="font-bold">{{ $application->rotation_slots()->count() }}</p>
                    </div>
                    <div class="mt-2">
                        <p class="gray-font">Fee</p>
                        <p class="font-bold">${{ $price }}</p>
                    </div>
                    <div class="mt-2">
                        <p class="gray-font">Status</p>
                        <p class="font-bold capitalize">{{ $application->status }}</p>
                    </div>
                </div>
            </div>
            @if (count($rotation->images) > 0)
                <div class="desc pb-3">
                    <p class="mt-3 mb-3"><b>Attached files</b></p>
                    {{--  <div class="flex">
                        https://app.findarotation.com/storage/qNzPA9y99hFbtHpSoou6CHabO5itY8YnAfC7n7wz.png
                        @foreach($rotation->images as $image)
                        <a target="_blank" href="{{ asset('storage/'.basename($image->path)) }}" data-lightbox="images" data-title="">
                            <img class="grid-col block mr-2" src="{{ asset('storage/'.basename($image->path)) }}" />
                        </a>
                        @endforeach
                    </div>  --}}
                    <section class="splide view-rotation" data-splide='{"arrows":false}'>
                        <div class="splide__track">
                              <ul class="splide__list">
                                  @if (count($rotation->images) > 0)
                                    @foreach($rotation->images as $image)
                                        <li class="splide__slide" style="background: transparent"><div class="slide-img" style="background-image: url(https://app.findarotation.com/storage/qNzPA9y99hFbtHpSoou6CHabO5itY8YnAfC7n7wz.png)"></div></li>
                                    @endforeach
                                    <li class="splide__slide" style="background: transparent"><div class="slide-img" style="background-image: url(https://app.findarotation.com/storage/swmlsYwMTfDghKkhlDZqNWzhS3pscJL8jrsffoRT.png)"></div></li>
                                    <li class="splide__slide" style="background: transparent"><div class="slide-img" style="background-image: url(https://app.findarotation.com/storage/qNzPA9y99hFbtHpSoou6CHabO5itY8YnAfC7n7wz.png)"></div></li>
                                    <li class="splide__slide" style="background: transparent"><div class="slide-img" style="background-image: url(https://app.findarotation.com/storage/swmlsYwMTfDghKkhlDZqNWzhS3pscJL8jrsffoRT.png)"></div></li>
                                    <li class="splide__slide" style="background: transparent"><div class="slide-img" style="background-image: url(https://app.findarotation.com/storage/qNzPA9y99hFbtHpSoou6CHabO5itY8YnAfC7n7wz.png)"></div></li>
                                    <li class="splide__slide" style="background: transparent"><div class="slide-img" style="background-image: url(https://app.findarotation.com/storage/qNzPA9y99hFbtHpSoou6CHabO5itY8YnAfC7n7wz.png)"></div></li>
                                    <li class="splide__slide" style="background: transparent"><div class="slide-img" style="background-image: url(https://app.findarotation.com/storage/qNzPA9y99hFbtHpSoou6CHabO5itY8YnAfC7n7wz.png)"></div></li>
                              @endif
                              </ul>
                        </div>
                      </section>
                </div>
            @endif
            @if (count($rotation->file_types) > 0)
                <div class="flex md:flex-row flex-col mt-2">
                    <div class="">
                        <p class="mb-3"><b>Documents required</b></p>
                        <ul>
                            @foreach($rotation->file_types as $fileType)
                            <li><p><x-icons.clip/></p><span></span><p>{{ $fileType->name }}<p></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>
        @if (app('request')->input('success')=="true")
        <div class="mt-4 p-4 bg-greenlight border-green rounded-3xl">
            <p class="text-lg font-semibold mb-1">Payment successful</p>
            <p class="gray-font">Your payment was successful, and vour rotation is confirmed. Your preceptor has been notified and will reach out to vou soon with further instructions.</p>
        </div>
        @elseif (app('request')->input('success')=="failed")
        <div class="mt-4 p-4 bg-red-300 border-green rounded-3xl flex flex-row">
            <div class="mr-4 flex-1">
                <p class="text-lg font-semibold mb-1">Payment unsuccessful</p>
                <p class="gray-font">Your payment was unsuccessful. Click on the button below to try again.</p>
            </div>
            <div class="flex flex-col items-center">
                <p class="ml-4 text-xl font-semibold">${{ $price }}</p>
                <a href="{{ route('student-application-pay',['application' => $application]) }}" class="font-semibold inline-block text-center px-6 py-2 bg-green hover:opacity-75 text-white rounded-lg text-sm" style="min-width: 150px">Pay Now</a>
            </div>
        </div>
        @else
            @if ($application->status=="accepted")
            <div class="mt-4 p-4 bg-greenlight border-green rounded-3xl flex flex-row">
                <div class="mr-4 flex-1">
                    <p class="text-lg font-semibold mb-1">Make payment</p>
                    <p class="gray-font max-w-xl">Click on the button below to pay and confirm vour rotation. Please note that vou will be sent to Stripe, our payment processor. Once your payment is complete you will be sent back to FindARotation.</p>
                </div>
                <div class="flex flex-col items-center justify-center">
                    <p class="ml-4 text-xl font-semibold">${{ $price }}</p>
                    <a href="{{ route('student-application-pay',['application' => $application]) }}" class="font-semibold inline-block text-center px-6 py-2 bg-green hover:opacity-75 text-white rounded-lg text-sm" style="min-width: 150px">Pay Now</a>
                    <p class="ml-4 text-sm gray-font">Service Fee: ${{ $fee }}</p>
                    <p class="ml-4 text-sm gray-font">Total: ${{ $fee + $price }}</p>
                </div>
            </div>
            @endif
        @endif
            <p class="text-xl mb-2 font-bold mb-5">Previous Messages</p>
            <div class="ovflow mt-12 px-2 message-container container-fluid row messages">
            @if (count($messages) > 0)
                @foreach($messages as $message)
                <div class="flex mb-3 {{$message->user->role == 'preceptor' ? 'justify-start' : 'justify-end'}}">
                    {{--  show profile image for the other user  --}}
                    @if ($message->user != Auth::user())
                        <img src="{{$message->user->profile_image!=null ? $message->user->profile_image : asset('images/blank-profile.png')}}"/>
                    @endif
                    <div class="mb-2 p-4 flex md:flex-row flex-col justify-between {{ $message->user->role == 'preceptor' ? 'gray-buble' : 'green-buble'}}">
                        <div class="md:w-320">
                            <b class="text-sm">{{ $message->user == Auth::user() ? 'You' : $message->user->name() }}</b>
                            <p class="md:mt-0 mt-2 gray-font text-sm">@php echo $message->message; @endphp</p>
                        </div>
                        <p class="text-sm font-bold"><span class="green-font">{{ \Carbon\Carbon::parse($message->created_at)->diffForHumans() }}</span><br/> {{ Carbon\Carbon::parse($message->created_at)->toFormattedDateString() }}</p>
                    </div>
                </div>
                @endforeach
            @else
                <p>No messages exchanged yet.</p>
            @endif
        </div>
        <div class="mt-12 px-2 message-container">
            <form id="form" method="POST" enctype='multipart/form-data' action="{{ route('message-send') }}" class="p-4 mb-4 mt-10">
                @csrf
                <input type="hidden" value="{{ $application->id }}" name="application_id" />
                <div class="mt-4 flex items-center justify-between">
                    <textarea id="message" name="message" rows="5" class="block w-full" placeholder="Type a message" required></textarea>
                    <button class="btn2 btn-green ml-5">Post message</button>
                </div>

            </form>
        </div>

    </div>
    @push('styles')
        <link href="{{ asset('css/splide.min.css') }}" rel="stylesheet">
    @endpush
    @push('scripts')
    <script src="{{ asset('js/splide.min.js') }}"></script>
    <script src="https://js.pusher.com/5.0/pusher.min.js"></script>
    <script>
        var user_id= {{Auth::user()->id}};
        var PUSHER_APP_KEY= '{{ $_SERVER['PUSHER_APP_KEY'] }}';
        var PUSHER_APP_CLUSTER= '{{ $_SERVER['PUSHER_APP_CLUSTER'] }}';
        var application_id = {{ $application->id }}
        $(document).ready(function() {
            new Splide( '.splide',{  perPage: 5, rewind : true,} ).mount();
        })
    </script>
        <script src="{{ asset('js/messages.js') }}"></script>
    @endpush

</x-app-layout>
