<x-app-layout>
    <!-- Metadata -->
    @section ('title', 'Verify email | Find a Rotation')
    @section ('description', 'Verify your email')
    <div class="logo-container justify-center flex"><x-icons.logo/></div>
    <x-auth-squard>
        <h1 class="font-black text-2xl mb-4 text-center">Confirm your E-mail</h1>

        <div class="mb-4">
            {{ __('An email was sent to your mail with a confirmation link. If you have not received the letter, click the button below.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <div>
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <x-button-full>Send Again</x-button-full>
                </div>
            </form>
        </div>
        <div class="text-center">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
    
                <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900" style="margin-top:20px">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </x-auth-squard>
</x-app-layout>
