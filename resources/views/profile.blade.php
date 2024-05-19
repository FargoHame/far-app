<x-app-layout>
  @section ('title', "View profile")

  <div class="mx-auto w-full max-w-4xl px-4 pt-5">
    <h1 class="text-3xl font-bold pb-3 justify-between flex">Edit Profile
      {{-- @if(!Auth::user()->oauth_provider) <span class="gray-font text-xs">{{ Auth::user()->email }}</span> @endif --}}
    </h1>
    <div id="tabs">
      <a href="/public-profile/{{Auth::user()->id}}" class="green-font font-bold flex items-center md:hidden justify-end mb-3"><x-icons.eye /> <span class="pl-2">View my public profile</span></a>
      <div class="border-b flex justify-between border-b-gray-300">
        <div class="flex header">
          @if(Auth::user()->role == 'preceptor')
          <a href="#" data-tab="tabs-1" class="font-medium text-xl pb-3 mr-5 border-b-4 border-black">Profile</a>
          <a href="#" data-tab="tabs-2" class="font-medium text-xl pb-3 mr-5 opacity-30">Password</a>
          @elseif (Auth::user()->role=='student')
          <a href="#" data-tab="tabs-1" class="font-medium text-xl pb-3 mr-5 border-b-4 border-black">Profile</a>
          <a href="#" data-tab="tabs-2" class="font-medium text-xl pb-3 mr-5 opacity-30">Password</a>
          @endif
        </div>
        <a href="/public-profile/{{Auth::user()->id}}" class="green-font font-bold md:flex items-center hidden"><x-icons.eye /> <span class="pl-2">View my public profile</span></a>
      </div>
      @if (session('profileBioStatus'))
      <p class="bg-green text-white p-4 mb-4">{{ session('profileBioStatus') }}</p>
      @endif

      @if (session('profilePhotoError'))
      <p class="bg-red-600 text-white p-4 mb-4">{{ session('profilePhotoError') }}</p>
      @endif

      <x-auth-validation-errors class="mb-6 bg-red-600 p-2" :errors="$errors->profileBioErrors" />
      {{-- START USER INFO SECTION  --}}
      <div id="tabs-1" class="tab-body">
        <h2 class="mt-7 font-bold text-2xl mb-1">About</h2>
        <h4 class="text-gray-400 font-medium text-xl mb-3">Tell us about yourself so startups know who you are.</h4>
        <form method="post" action="{{ route('profile-update-bio') }}" enctype="multipart/form-data" class="filter pb-7" style="border-bottom: 0">
          @csrf
          {{-- START image section  --}}
          <div class="mr-5">
            @if(Auth::user()->role == 'preceptor')
            <div class="flex items-center">
              <label class="bg-cover block bg-center h-24 w-24 rounded-full cursor-pointer" style="background-image: url({{Auth::user()->photo()}})" for="photo">
                <input id="photo" name="photo" type="file" class="mt-1 w-full hidden photo" accept="image/png, image/jpeg, image/jpg, image/svg" />
              </label>
              <button class="btn btn-green min-w-200" type="submit" id="saveBtn" style="display: none; margin-left: 10px; padding:5px">Save</button>
            </div>
            @if (Auth::user()->profile_image)
            <button type="button" class="text-red-600 text-sm mt-3 w-24" onclick="remove('{{Auth::user()->profile_image}}')">Remove</button>
            @endif
            @elseif (Auth::user()->role == 'student')
            <div class="flex items-center">
              <label class="bg-cover block bg-center h-24 w-24 rounded-full cursor-pointer" style="background-image: url({{Auth::user()->photo()}})" for="photo">
                <input id="photo" name="photo" type="file" class="mt-1 w-full hidden photo" accept="image/png, image/jpeg, image/jpg, image/svg" />
              </label>
              <button class="btn btn-green min-w-200" type="submit" id="saveBtn" style="display: none; margin-left: 10px; padding:5px">Save</button>
            </div>
            @endif
          </div>
          {{-- END image section  --}}
          <div class="mt-6">
            <x-label for="first_name" :value="__('Your first name')" style="font-weight:600" />
            <x-input id="first_name" name="first_name" class="gray-font block mt-1 w-full input-field h-12" value="{{ Auth::user()->first_name }}" required />
          </div>
          <div class="mt-6">
            <x-label for="last_name" :value="__('Your last name')" style="font-weight:600" />
            <x-input id="last_name" name="last_name" class="gray-font block mt-1 w-full input-field h-12" value="{{ Auth::user()->last_name }}" required />
          </div>
          @if(Auth::user()->role == 'affiliate')
          <div class="mt-6">
            <x-label for="role" :value="__('Role')" style="font-weight:600" />
            <x-select id="role" name="role" :values="['student' => 'Student', 'preceptor' => 'Preceptor', 'affiliate' => 'Affiliate']"  class="block w-full" value="{{Auth::user()->role}}" />
          </div>
          @endif
          @if(Auth::user()->role == 'preceptor')
          <div class="mt-6">
            <x-label for="company" :value="__('Company name')" style="font-weight:600" />
            <x-input id="company" name="company" class="gray-font block mt-1 w-full input-field h-12" value="{{ Auth::user()->company }}" required />
          </div>
          <div class="mt-6">
            @if($specialties != null)
            @if (count($specialties) > 1)
            <x-label for="specialities" :value="__('Type of specialities')" />
            @foreach ($specialties as $key => $specialty )
            <div class="flex justify-between items-center mb-2">
              <div class="w-full mr-5">
                <x-select id="specialities" name="specialities[]" :values="\App\Models\Specialty::getSpecialties(true)" class="block w-full" value="{{$specialty}}" />
              </div>
              @if ($key == 0)
              <button type="button" class="btn-green min-w-100 rounded h-9" id="more">Add More</button>
              @else
              <button type="button" class="text-red-500 min-w-100 rounded h-9" id="remove">Remove</button>
              @endif
            </div>
            @endforeach
            @else
            <x-label for="specialities" :value="__('Type of specialities')" />
            <div class="flex justify-between items-center">
              <div class="w-full mr-5">
                <x-select id="specialities" name="specialities[]" :values="\App\Models\Specialty::getSpecialties(true)" class="block w-full" value="{{$specialties[0]}}" />
              </div>
              <button type="button" class="btn-green min-w-100 rounded h-9" id="more">Add More</button>
            </div>
            @endif
            @else
            <x-label for="specialities" :value="__('Type of specialities')" />
            <div class="flex justify-between items-center">
              <div class="w-full mr-5">
                <x-select id="specialities" name="specialities[]" :values="\App\Models\Specialty::getSpecialties(true)" class="block w-full" />
              </div>
              <button type="button" class="btn-green min-w-100 rounded h-9" id="more">Add More</button>
            </div>
            @endif
          </div>
          {{-- <div class="mt-6">
                  <x-label for="specialities" :value="__('Type of specialities')"/>
                  <div class="flex justify-between items-center">
                    <div class="w-full mr-5">
                      <x-select id="specialities" name="specialities[]" :values="\App\Models\Specialty::getSpecialties(true)" class="block w-full" value="{{Auth::user()->speciality}}"/>
      </div>
      <button type="button" class="btn-green min-w-100 rounded h-9" id="more">Add More</button>
    </div>
  </div> --}}
  <div class="mt-2" id="speciality-container"></div>
  <div class="mt-6">
    <x-label for="description" :value="__('Description')" />
    <textarea id="description" name="description" class="gray-font block mt-1 w-full input-field border rounded-sm border-gray-300 ring-0 focus:ring-0 focus:outline-none focus:border-far-green-dark px-2" style="height: 270px">{{Auth::user()->description}}</textarea>
  </div>
  @endif
  @if(Auth::user()->role == 'student')
  <div class="mt-6">
    <x-label for="location" :value="__('Where are you base?')" />
    <x-select id="location" name="location" :values="Auth::user()->getUSStates()" class="block w-full" value="{{Auth::user()->location}}" />
  </div>
  <div class="mt-6">
    <x-label for="description" :value="__('Your bio')" />
    <textarea id="description" name="description" class="gray-font block mt-1 w-full input-field border rounded-sm border-gray-300 ring-0 focus:ring-0 focus:outline-none focus:border-far-green-dark px-2" style="height: 270px">{{Auth::user()->description}}</textarea>
  </div>
  <h2 class="mt-7 font-bold text-2xl mb-1">Profesional Details</h2>
  <div class="mt-6 grid grid-cols-3 gap-4">
    <div class="col-span-2">
      <x-label for="school" :value="__('Your school')" style="font-weight:600" />
      <x-autocomplete name="school" id="school" autocompleteRoute="schools-autocomplete" :value="Auth::user()->school"></x-autocomplete>
    </div>
    <div>
      <x-label for="degree" :value="__('Degree')" />
      <x-select id="degree" name="degree" :values="['Pre-med' => 'Pre-med','Medical Student MD/DO' => 'Medical Student MD/DO', 'Medical Graduate MD/DO' => 'Medical Graduate MD/DO']" class="block w-full" value="{{Auth::user()->degree}}" />
    </div>
  </div>
  @endif
  <h2 class="mt-7 font-bold text-2xl mb-1">Social Profiles</h2>
  <h4 class="text-gray-400 font-medium text-xl mb-3">Where can people find you online?</h4>
  <div class="mt-6">
    <x-label for="linkedin" :value="__('Lindedin')" style="font-weight:600" />
    <x-input id="linkedin" name="linkedin" class="gray-font block mt-1 w-full input-field h-12" value="{{ isset($social['linkedin']) ? $social['linkedin'] : ''  }}" />
  </div>
  <div class="mt-6">
    <x-label for="twitter" :value="__('Twitter')" style="font-weight:600" />
    <x-input id="twitter" name="twitter" class="gray-font block mt-1 w-full input-field h-12" value="{{ isset($social['twitter']) ? $social['twitter'] : ''  }}" />
  </div>
  <div class="mt-6">
    <x-label for="facebook" :value="__('Facebook')" style="font-weight:600" />
    <x-input id="facebook" name="facebook" class="gray-font block mt-1 w-full input-field h-12" value="{{ isset($social['facebook']) ? $social['facebook'] : ''  }}" />
  </div>
  <div class="mt-6">
    <x-label for="instagram" :value="__('Instagram')" style="font-weight:600" />
    <x-input id="instagram" name="instagram" class="gray-font block mt-1 w-full input-field h-12" value="{{ isset($social['instagram']) ? $social['instagram'] : ''  }}" />
  </div>
  <div class="mt-6">
    <button type="submit" class="btn btn-green min-w-200 w-full" style="height: 40px;margin-top: 0;font-weight: normal;font-size: 14px;">Save changes</button>
  </div>
  </form>
  @if (Auth::user()->role!='admin')
  <h2 class="mt-5 font-bold text-2xl mb-3">Affiliate Program</h2>
  @if ($prefinay==null)
  <div class='prefinery-form-embed pb-5' data-prefinery-prefill-email="{{ Auth::user()->email }}"></div>
  @else
  <div id="embed-prefinary"></div>
  @endif
  @if (Auth::user()->code_prefinary!=null )
  @if (Auth::user()->gigwage_id == null)
  <div class="md:grid grid-col-3 grid-flow-col gap-5 items-end pb-4">
    <div class="mt-5">
      <h2 class="text-2xl font-bold pb-3">Connect your bank account for affliate rewards</h2>
    </div>
    <div class="mt-3 md:text-right">
      <a href="{{ route('connect-account') }}">
        <button onclick="" class="btn btn-green min-w-200" style="height: 40px;margin-top: 0;font-weight: normal;font-size: 14px;">Connect to GigWage</button>
      </a>
    </div>
  </div>
  @endif
  @endif
  @endif
  </div>
  {{-- END USER INFO SECTION  --}}
  {{-- START password section  --}}
  <div id="tabs-2" class="tab-body hidden">
    <h2 class="mt-7 font-bold text-2xl mb-1">Password</h2>
    @if (session('profilePasswordStatus'))
    <p class="bg-green text-white p-4 mb-4">{{ session('profilePasswordStatus') }}</p>
    @endif

    <x-auth-validation-errors class="mb-6 bg-red-600 p-2" :errors="$errors->profilePasswordErrors" />

    <form method="post" action="{{ route('profile-update-password') }}" class="filter pb-8" style="border-bottom: 0">
      @csrf
      <div class="mt-6">
        <x-label for="password" :value="__('New password')" style="font-weight:600" />
        <x-input id="password" name="password" type="password" class="gray-font block mt-1 w-full input-field h-12" placeholder="New password" required />
      </div>

      <div class="mt-6">
        <x-label for="password" :value="__('Confirm password')" style="font-weight:600" />
        <x-input id="password_confirmation" name="password_confirmation" type="password" class="gray-font block mt-1 w-full input-field h-12" placeholder="Password confirmation" required />
      </div>
      <div class="mt-6">
        <button type="submit" class="btn btn-green min-w-200 w-full" style="height: 40px;margin-top: 0;font-weight: normal;font-size: 14px;">Save changes</button>
      </div>
    </form>
  </div>
  {{-- END password section  --}}
  </div>
  </div>
  @push('scripts')
  <script>
    prefinery = window.prefinery || function() {
      (window.prefinery.q = window.prefinery.q || []).push(arguments)
    };
  </script>
  <script src="https://widget.prefinery.com/widget/v2/nz2qvwiq.js" defer></script>
  <script>
    // Store the initial image URL
    const initialImageUrl = "{{Auth::user()->photo()}}";

    // Get the file input element
    const photoInput = document.getElementById("photo");

    // Get the "Save" button element
    const saveBtn = document.getElementById("saveBtn");

    // Add an event listener to the file input
    photoInput.addEventListener("change", (event) => {
      // Check if the file input has a file selected
      if (event.target.files.length > 0) {
        // Get the selected file object
        const file = event.target.files[0];

        // Create a URL for the selected file
        const imageUrl = URL.createObjectURL(file);

        // Compare the initial image URL with the new image URL
        if (imageUrl !== initialImageUrl) {
          // Show the "Save" button
          saveBtn.style.display = "block";
        } else {
          // Hide the "Save" button
          saveBtn.style.display = "none";
        }
      }
    });
  </script>
  <script>
  {{-- script for tabs  --}}
  $('#tabs .header a').click(function(){
  $('#tabs .header a').removeClass('border-b-4').removeClass('border-black')
  $('#tabs .header a').addClass('opacity-30')
  $(this).addClass('border-b-4').addClass('border-black')
  $(this).removeClass('opacity-30')
  const id = $(this).attr('data-tab');
  $('.tab-body').addClass('hidden')
  $(`#${id}`).removeClass('hidden')
  })
  $('.photo').change(function(){
  const element = this;
  const file = this.files[0];
  if(file){
  let reader = new FileReader();
  reader.onload = function(event){
  @if(Auth::user()->role == 'preceptor')
  $(element).parent().css('background-image',`url(${event.target.result})`)
  @else
  $(element).parent().parent().find('.bg-cover').css('background-image',`url(${event.target.result})`)
  @endif
  }
  reader.readAsDataURL(file);
  }
  })
  $('#more').click(function(){
  $('#specialities').parent().clone().appendTo('#speciality-container')
  $('<div class="mt-2"></div>').appendTo('#speciality-container')
  })
  $('#remove').click(function(){
  $(this).parent().remove()
  })
  {{-- this is to show the ref link to share  --}}
  if(location.search===''){
  prefinery('getUser',{email:'{{Auth::user()->email}}',signature:'{{$hash}}'},function(user){
  if(user){

  if('{{Auth::user()->get_code_prefinary()}}'=='null')
  location.href='/profile/ref/'+user.data.referral_code

  prefinery('embedReferralPage', {
  email: '{{Auth::user()->email}}',
  signature: '{{$hash}}',
  dom_id: 'embed-prefinary',
  });
  }
  })
  }
  function remove(val){
  {{-- console.log(val)  --}}
  window.location.href = '/delete-file?file='+val.split('https://findarotation.s3.us-east-2.amazonaws.com/').pop()
  }
  </script>
  @endpush
</x-app-layout>