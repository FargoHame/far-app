<x-app-layout>
  @section ('title', "Edit user")

    <div class="mx-auto md:px-0 md:max-w-screen-sm md:w-auto w-full px-4 pt-5 md:mt-6">
      <h1 class="text-3xl font-bold pb-3 border-b border-gray-600 border-dashed">Edit user</h1>

      <h2 class="text-2xl font-bold mt-6 mb-4">Biodata</h2>
      @if (session('userBioStatus'))
        <p class="bg-green-100 p-4 mb-4">{{ session('userBioStatus') }}</p>
      @endif

      <x-auth-validation-errors class="mb-6 bg-red-300 p-2" :errors="$errors->userBioErrors" />

      <form method="post" action="{{ route('admin-user-update-bio') }}">
        @csrf
        <input type="hidden" value="{{ $user->id }}" name="id" />

        <div class="mt-4">
          <x-label for="first_name" :value="__('Frst name')" />
          <x-input id="first_name" name="first_name" class="block mt-1 w-full" value="{{ $user->first_name }}" required />
        </div>

        <div class="mt-4">
          <x-label for="last_name" :value="__('Last name')" />
          <x-input id="last_name" name="last_name" class="block mt-1 w-full" value="{{ $user->last_name }}" required />
        </div>

        <div class="mt-4 mb-1">
          <x-label for="email" :value="__('Email')" />
          <x-input id="email" name="email" class="block mt-1 w-full" value="{{ $user->email }}" required />
        </div>

        <div class="mt-3 border-t border-dashed border-gray-500 pt-3 text-right">
          <x-button>Save changes</x-button>
        </div>
      </form>
    </div>

    @if($user->role == 'student')
    <div class="mx-auto md:px-0 md:max-w-screen-sm md:w-auto w-full px-4 pt-5 md:mt-6">
      <h2 class="text-2xl font-bold mt-6 mb-4">Professional Details</h2>
      @if (session('userProfessionalStatus'))
        <p class="bg-green-100 p-4 mb-4">{{ session('userProfessionalStatus') }}</p>
      @endif

      <x-auth-validation-errors class="mb-6 bg-red-300 p-2" :errors="$errors->userProfessionalErrors" />

      <form method="post" action="{{ route('admin-user-update-professional') }}">
        @csrf
        <input type="hidden" value="{{ $user->id }}" name="id" />

        <div class="mt-4">
          <x-label for="school" :value="__('School')" />
          <x-autocomplete name="school" id="school" autocompleteRoute="schools-autocomplete" value="{{ $user->school }}" required></x-autocomplete>
        </div>

        <div class="mt-4">
          <x-label for="degree" :value="__('Your degree')" />
          <x-select id="degree" name="degree" :values="['Pre-med' => 'Pre-med','Medical Student MD/DO' => 'Medical Student MD/DO', 'Medical Graduate MD/DO' => 'Medical Graduate MD/DO']" class="block w-full" value="{{ $user->degree }}" />
        </div>

        <div class="mt-3 border-t border-dashed border-gray-500 pt-3 text-right">
          <x-button>Save changes</x-button>
        </div>
      </form>
    </div>
    @endif

    @if($user->role == 'preceptor')
    <div class="mx-auto md:px-0 md:max-w-screen-sm md:w-auto w-full px-4 pt-5 md:mt-6">
      <h2 class="text-2xl font-bold mt-6 mb-4">Profile picture</h2>
      @if (session('userPhotoStatus'))
        <p class="bg-green-100 p-4 mb-4">{{ session('userPhotoStatus') }}</p>
      @endif

      <x-auth-validation-errors class="mb-6 bg-red-300 p-2" :errors="$errors->profilePhotoErrors" />

      <form method="post" action="{{ route('admin-user-update-photo') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" value="{{ $user->id }}" name="id" />

        <div class="mt-4">
          <img class="w-200 mb-4" src="{{ $user->photo() }}" />
          <x-label for="photo" :value="__('Change profile picture')" />
          <input id="photo" name="photo" type="file" class="block mt-1 w-full" required>
        </div>

        <div class="mt-3 border-t border-dashed border-gray-500 pt-3 text-right">
          <x-button>Update</x-button>
        </div>
      </form>
    </div>
    @endif

    <div class="mx-auto md:px-0 md:max-w-screen-sm md:w-auto w-full px-4 pt-5 md:mt-6">
      <h2 class="text-2xl font-bold mt-6 mb-4">Password</h2>
      @if (session('userPasswordStatus'))
        <p class="bg-green-100 p-4 mb-4">{{ session('userPasswordStatus') }}</p>
      @endif

      <x-auth-validation-errors class="mb-6 bg-red-300 p-2" :errors="$errors->userPasswordErrors" />

      <form method="post" action="{{ route('admin-user-update-password') }}">
        @csrf
        <input type="hidden" value="{{ $user->id }}" name="id" />

        <div class="mt-4">
          <x-label for="password" :value="__('New password')" />
          <x-input id="password" name="password" type="password" class="block mt-1 w-full" placeholder="New password" required />
        </div>

        <div class="mt-4">
          <x-label for="password" :value="__('Confirm password')" />
          <x-input id="password_confirmation" name="password_confirmation" type="password" class="block mt-1 w-full" placeholder="Password confirmation" required />
        </div>

        <div class="mt-3 border-t border-dashed border-gray-500 pt-3 text-right">
          <x-button>Save changes</x-button>
        </div>
      </form>
    </div>

</x-app-layout>
