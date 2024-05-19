<x-app-layout>
    @section ('title', "public profile")
        <div class="mx-auto w-full max-w-4xl px-4 pt-5">
            <div id="tabs">
            @if ($user->role == 'preceptor')
                <div class="flex justify-between mb-10">
                    <div class="flex header border-b border-b-gray-300 pr-5">
                        <a href="#" data-tab="tabs-1" class="font-semibold text-xl pb-3 mr-5 border-b-4 border-black">Public Profile</a>
                        <a href="#" data-tab="tabs-2" class="font-semibold text-xl pb-3 mr-5 opacity-30">Jobs</a>
                    </div>
                </div>
            @endif
                <div id="tabs-1" class="tab-body">
                    <div class="flex">
                        <div class="bg-cover block bg-center h-24 w-24 rounded-full cursor-pointer" style="background-image: url({{$user->profile_image != null ? $user->profile_image : '/images/blank-profile.png'}})"></div>
                        <div class="pl-3" style="max-width: 75%">
                            <h4 class="font-bold text-xl">{{$user->first_name}} {{$user->last_name}}</h4>
                            @if ($user->role == 'student')
                                <p class="text-gray-500 text-lg font-medium">{{$user->school}} </br> {{$user->degree}}</p>
                            @else
                                <p class="text-gray-500 text-lg font-medium">{{$user->location}}, {{$user->company}}</p>
                            @endif
                        </div>
                    </div>
                    <h2 class="mt-10 font-bold text-2xl mb-3">About me</h2>
                    <p class="text-gray-500 text-lg font-medium mb-10">{{$user->description != null ? $user->description : 'No set yet'}}</p>
                    {{--  START social section  --}}
                    <h2 class="mt-10 font-bold text-2xl mb-3">In the web</h2>
                    <div class="md:flex">
                        @if($user->social_links != null)
                            @if(isset($user->social_links['linkedin']))
                                <a target="_blank" rel="noreferrer" href="{{$user->social_links['linkedin']}}" class="mr-5 mb-5 rounded-xl h-14 w-52 text-white text-lg font-medium flex items-center justify-center" style="background: #0178b5"><i class="fa fa-linkedin text-white mr-2" style="font-size: 22px"></i> Linkedin Account </a>
                            @endif
                            @if(isset($user->social_links['twitter']))
                                <a target="_blank" rel="noreferrer" href="{{$user->social_links['twitter']}}" class="mr-5 mb-5 rounded-xl h-14 w-52 text-white text-lg font-medium flex items-center justify-center" style="background: #1DA1F2"><i class="fa fa-twitter text-white mr-2" style="font-size: 22px"></i> Twitter Account </a>
                            @endif
                            @if(isset($user->social_links['facebook']))
                                <a target="_blank" rel="noreferrer" href="{{$user->social_links['facebook']}}" class="mr-5 mb-5 rounded-xl h-14 w-52 text-white text-lg font-medium flex items-center justify-center" style="background: #3c5a98"><i class="fa fa-facebook text-white mr-2" style="font-size: 22px"></i> Facebook Account </a>
                            @endif
                            @if(isset($user->social_links['instagram']))
                                <a target="_blank" rel="noreferrer" href="{{$user->social_links['instagram']}}" class="mr-5 mb-5 rounded-xl h-14 w-52 text-white text-lg font-medium flex items-center justify-center" style="background: #cb2128"><i class="fa fa-instagram text-white mr-2" style="font-size: 22px"></i> Instagram Account </a>
                            @endif
                        @else
                        <p class="text-gray-500 text-lg font-medium mb-10">No set yet</p>
                        @endif
                    </div>
                    {{--  END social section  --}}
                    @if ($user->speciality != null)
                        <h2 class="mt-10 font-bold text-2xl mb-3">Open to the following roles</h2>
                        <ul class="mb-5">
                            @foreach ($user->speciality as $speciality )
                                <li class="inline-block px-3 py-2 rounded-2xl mr-2 mb-2" style="background: rgba(165, 165, 165, 0.25); color: rgba(0, 0, 0, 0.5)">{{$speciality}}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    @push('scripts')
        <script>
          {{--  script for tabs  --}}
          $('#tabs .header a').click(function(){
            $('#tabs .header a').removeClass('border-b-4').removeClass('border-black')
            $('#tabs .header a').addClass('opacity-30')
            $(this).addClass('border-b-4').addClass('border-black')
            $(this).removeClass('opacity-30')
            const id = $(this).attr('data-tab');
            $('.tab-body').addClass('hidden')
            $(`#${id}`).removeClass('hidden')
          })
        </script>
    @endpush
</x-app-layout>
  