<x-app-layout>
    <!-- Metadata -->
    @section ('title', 'Forgot password | Find a Rotation')
    @section ('description', 'Get a link to reset your password')
    <x-auth-squard>
        <h1 class="font-black text-2xl mb-4 text-cente">Forgot password</h1>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />
        <form method="POST" action="{{ route('password.email') }}" class="form-style">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="flex items-center justify-center mt-4">
                <x-button class="w-full px-6 py-2 bg-far-green-dark hover:opacity-75 btn">
                    {{ __('Email Reset Link') }}
                </x-button>
            </div>
        </form>
    </x-auth-squard>
</x-app-layout>