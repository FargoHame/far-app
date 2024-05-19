<x-app-layout>
    <!-- Metadata -->
    @section ('title', 'Sign up | Find a Rotation')
    @section ('description', 'Sign up for Find a Rotation')



    <x-auth-authentication-card>
        <div class="space"></div>
        <x-social-login/>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors"/>
        @if (session('oauth-error') !== null)
            <x-alert title='Register Error' message="{{session('oauth-error')}}" type="error"></x-alert>
        @endif
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Role -->
            <div style="display: none">
                <x-label for="role" :value="__('I am a')"/>
                <x-select x-model="role" id="role" class="block mt-1 w-full" type="text" name="role"
                          :value="old('role')" :values="['affiliate' => 'Affiliate']" required
                          autofocus/>
            </div>
            <!-- Name -->
            <div class="group flex items-center justify-between">
                <div class="mt-4 field-container">
                    <x-label for="first_name" :value="__('First name')"/>
                    <x-input id="first_name" class="block mt-1 w-full input-field" type="text" name="first_name"
                             :value="old('first_name')" required autofocus/>
                </div>
                <div class="mt-4 field-container">
                    <x-label for="last_name" :value="__('Last name')"/>
                    <x-input id="last_name" class="block mt-1 w-full input-field" type="text" name="last_name"
                             :value="old('last_name')" required autofocus/>
                </div>
            </div>
            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('E-mail')"/>
                <x-input id="email" class="block mt-1 w-full input-field" type="email" name="email"
                         :value="old('email')" required/>
            </div>

            <div class="group flex items-center justify-between">
                <!-- Password -->
                <div class="mt-4 field-container">
                    <x-label for="password" :value="__('Password')"/>
                    <x-input id="password" class="block mt-1 w-full input-field" type="password" name="password"
                             required autocomplete="new-password" isPassword=true/>
                </div>

                <!-- Confirm Password -->
                <div class="mt-4 field-container">
                    <x-label for="password_confirmation" :value="__('Confirm password')"/>
                    <x-input id="password_confirmation" class="block mt-1 w-full input-field" type="password"
                             name="password_confirmation" required isPassword=true/>
                </div>
            </div>
            <!-- terms/ conditions -->
            <div class="flex md:flex-row flex-col md:items-center justify-around mt-4">
                <label for="terms" class="inline-flex items-center">
                    <input id="terms" type="checkbox"
                           class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                           name="terms">
                    <span class="ml-2 text-sm">{{ __('I accept') }}<a href="#" class="forgot">Terms</a> and <a href="#"
                                                                                                               class="forgot">conditions</a></span>
                </label>
            </div>
            <div class="block mt-4">
                <button class="w-full px-6 py-2 bg-far-green-dark hover:opacity-75 btn">
                    {{ __('Sign Up') }}
                </button>
            </div>
        </form>
    </x-auth-authentication-card>

</x-app-layout>
