<x-app-layout>
    @section ('title', "View application")

      <div class="mx-auto w-full max-w-7xl px-4 pt-5" x-data="{dialog:{{request()->has('status')}}}">
        @if ($application->status == "pending")
            <div class="mt-4 p-4">
                <div class="text-right">
                    <a href="{{ route('preceptor-application-reject',['application' => $application]) }}" class="inline-block text-center md:min-w-100 px-6 py-2 bg-red-500 btn-simple text-sm">Reject</a>
                    <a href="{{ route('preceptor-application-accept',['application' => $application]) }}" class="btn-simple btn-green inline-block text-center md:min-w-100 px-6 py-2 hover:opacity-75 text-sm">Accept</a>
                </div>
            </div>
        @endif
          <div class="p-8 mb-6 card-application">
              <div class="flex justify-between">
                  <div class="flex md:flex-row md:items-center mb-4">
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
                <p class="text-lg mt-8 mb-4"><b>Student:</b> {{ $application->student->name() }}</p>

                <!-- Desktop -->
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
                        <td class="px-2 whitespace-nowrap text-left font-bold text-sm">${{ ($rotation->price_per_week_in_cents * $application->rotation_slots->count())/100 }}</td>
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
                        <p class="gray-font">Value</p>
                        <p class="font-bold">${{ ($rotation->price_per_week_in_cents * $application->rotation_slots->count())/100 }}</p>
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
                      <div class="flex">
                          @foreach($rotation->images as $image)
                          <a target="_blank" href="{{ asset('storage/'.basename($image->path)) }}" data-lightbox="images" data-title="">
                              <img class="grid-col block mr-2" src="{{ asset('storage/'.basename($image->path)) }}" />
                          </a>
                          @endforeach
                      </div>
                  </div>
              @endif
              @if (count($rotation->file_types) > 0)
                  <div class="flex md:flex-row flex-col mt-2 desc pb-3">
                      <div class="">
                          <p class="mb-3"><b>Documents required</b></p>
                          <ul>
                              @foreach($rotation->file_types as $fileType)
                              <li><p><x-icons.clip/></p><span></span><p>{{ $fileType->name }}</p></li>
                              @endforeach
                          </ul>
                      </div>
                  </div>
              @endif
              <div class="desc pb-3 mb-3 mt-2">
                <div class="">
                    <p class="mb-3"><b>Documents</b></p>
                    @if (count($application->files) > 0)
                        {{--  <td class="pr-2 whitespace-nowrap font-bold">Name</td>
                        <td class="px-2 whitespace-nowrap font-bold">Provided on</td>
                        <td class="px-2 whitespace-nowrap font-bold"></td>  --}}
                        @foreach($application->files as $file)
                        <div class="md:flex justify-between mb-3">
                            <p>{{ $file->filename }}</p>
                            <p>{{ $file->created_at->format('M d, Y') }} ({{ $file->file_type_id == null ? 'Via message':'With application' }})</p>
                            <a class="btn-green inline-block text-center md:min-w-100 rounded-lg px-6 py-2 hover:opacity-75" href="{{ $file->path }}">Download</a>
                        </div>
                        @endforeach
                    @else
                        <p class="text-xl mb-1 font-semibold">Documents</p>
                        <p>This student hasn’t attached any documents.</p>
                    @endif
                </div>
              </div>
          </div>
            <p class="text-xl mb-2 font-bold mb-5">Previous Messages</p>
            <div class="ovflow mt-12 px-2 message-container container-fluid row messages">
                @if (count($messages) > 0)
                  @foreach($messages as $message)
                    <div class="flex mb-3 {{ $message->user->role == 'preceptor' ? 'justify-end' : 'justify-start'}}">
                        @if ($message->user != Auth::user())
                            <img src="{{$message->user->profile_image!=null ?\App\Models\User::where(['id' => $message->user->id])->firstOrFail()->photo() : asset('/images/blank-profile.png')}}"/>
                        @endif
                        <div class="mb-2 p-4 flex md:flex-row flex-col justify-between {{ $message->user->role == 'preceptor' ? 'green-buble' : 'gray-buble'}}">
                            <div class="md:w-320">
                                <b class="text-sm">{{ $message->user == Auth::user() ? 'You' : $message->user->name() }}</b>
                                <p class="md:mt-0 mt-2 gray-font text-sm">@php echo $message->message; @endphp</p>
                            </div>
                            <p class="text-sm font-bold"><span class="green-font">{{ \Carbon\Carbon::parse($message->created_at)->diffForHumans() }}</span> <br/>{{ Carbon\Carbon::parse($message->created_at)->toFormattedDateString() }}</p>
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
        <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true" x-show="dialog" @click.outside="dialog = false">
            <div class="fixed inset-0 bg-black-trans bg-opacity-75 transition-opacity"></div>
                <div class="fixed inset-0 z-10 overflow-y-auto" style="top: 80px">
                    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                        <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-xs">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div>
                                    <h2 class="text-xl font-bold text-center green-font">{{$application->status=='accepted' ? 'Success' : 'Rejected'}}</h2>
                                    <div class="mt-4">
                                       <p class="text-center">The application has been {{$application->status=='accepted' ? 'accepted' : 'rejected'}} successfully</p>
                                       <div class="px-4 py-3 flex">
                                        <button type="button" class="btn w-full mr-3 btn-gray" @click="dialog=!dialog">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
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
