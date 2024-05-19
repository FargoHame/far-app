<div class="flex flex-col justify-center items-center @if(Request::is('register')) right-card @endif">
    <div class="logo-container"><x-icons.logo/></div>
    @if (Request::is('register-affiliate'))
        <h2 class="text-5xl font-bold mb-5 text-center md:text-left">
            Join today to become an Affiliate
            </br>
            <small class="block text-center text-sm mt-2">Earn rewards for every affiliate</small>
        </h2>
    @endif
    <div class="card-authentication">
        @if (!Request::is('register-affiliate'))
        <div class="tab-header">
            <div class="tab @if(Request::is('login')) active @endif">
                <a href="/login">
                    <h2>Sign In</h2>
                </a>
            </div>
            <div class="tab @if(Request::is('register')) active @endif">
                <a href="/register">
                    <h2>Sign Up</h2>
                </a>
            </div>
        </div>
        @endif
        <div class="tab-content">
            {{ $slot }}
        </div>
    </div>
</div>