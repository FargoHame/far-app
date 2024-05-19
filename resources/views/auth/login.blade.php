<x-app-layout>
    <!-- Metadata -->
    @section ('title', 'Login | Find a Rotation')
    @section ('description', 'Login to Find a Rotation')

    <x-auth-authentication-card>
        <x-social-login/>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('E-mail')" />
                <x-input id="email" class="input-field block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" isPassword=true/>
            </div>

            <!-- Remember Me -->
            <div class="flex md:flex-row flex-col md:items-center justify-around mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-sm">{{ __('Remember me') }}</span>
                </label>
                @if (Route::has('password.request'))
                <a class="md:order-none order-1 md:mt-0 mt-4 forgot" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
                @endif
            </div>
            <div class="block mt-4">
                <button class="w-full px-6 py-2 bg-far-green-dark hover:opacity-75 btn">
                    {{ __('Sign In') }}
                </button>
            </div>
        </form>
    </x-auth-authentication-card>
</x-app-layout>