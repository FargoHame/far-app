<x-app-layout>
    <!-- Metadata -->
    @section ('title', 'Confirm password | Find a Rotation')
    @section ('description', 'Confirm your password')

    <div class="md:max-w-screen-sm md:w-auto w-full mx-auto">
        <div class="md:mx-2 bg-far-green-light p-4 mt-12">
            <div class="font-medium text-sm mb-4">
                {{ __('This is a secure area. Please confirm your password before continuing.') }}
            </div>

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <!-- Password -->
                <div>
                    <x-label for="password" :value="__('Password')" />

                    <x-input id="password" class="block mt-1 w-full"
                                    type="password"
                                    name="password"
                                    required autocomplete="current-password" />
                </div>

                <div class="flex justify-end mt-4">
                    <x-button>
                        {{ __('Confirm') }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
