<x-app-layout>
    <!-- Metadata -->
    @section ('title', 'Reset password | Find a Rotation')
    @section ('description', 'Reset your password')

    <x-auth-squard>
        <h1 class="font-black text-2xl mb-4 text-cente">Reset password</h1>
        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.update') }}" class="form-style">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                    type="password"
                                    name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-center mt-4">
                <x-button class="w-full px-6 py-2 bg-far-green-dark hover:opacity-75 btn">
                    {{ __('Reset Password') }}
                </x-button>
            </div>
        </form>
    </x-auth-squard>
</x-app-layout>
