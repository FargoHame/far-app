<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Metadata: Information -->
    <title>@yield('title', 'Find a Rotation')</title>

    <!-- Metadata: Other -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">

    <!-- Scripts -->
    <script async src="https://js.stripe.com/v3/"></script>

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-P7MC9QB');
    </script>
    <!-- End Google Tag Manager -->

    <!-- Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P7MC9QB"
                height="0" width="0" style="display:none;visibility:hidden">
        </iframe>
    </noscript>

    <script src="https://use.fontawesome.com/71d4d89223.js"></script>
    <!-- End Google Tag Manager (noscript) -->

    <script>
    (function(d, params){
        var script = d.createElement('script');
        script.setAttribute('src', 'https://cdn.candu.ai/sdk/latest/candu.umd.js?token=' + params.clientToken);
        script.onload = function () {
            Candu.init(params);
        }
        d.head.appendChild(script);
    })(document, {
        clientToken: '6W4KbyXcTV',
    });
    </script>
    <!-- User segmentation start -->
<script>
window.usetifulTags = { userId : "EXAMPLE_USER_ID", segment: "EXAMPLE_SEGMENT_NAME", firstName : "EXAMPLE_NAME",     
};</script>
<!-- User segmentation end -->
<!-- Usetiful script start -->
            <script>
(function (w, d, s) {
    var a = d.getElementsByTagName('head')[0];
    var r = d.createElement('script');
    r.async = 1;
    r.src = s;
    r.setAttribute('id', 'usetifulScript');
    r.dataset.token = "b8b500b11f491d108376ba0b47ff878c";
                        a.appendChild(r);
  })(window, document, "<https://www.usetiful.com/dist/usetiful.js");</script>

<!-- Usetiful script end -->
    @stack('styles')
</head>

<body class="bg-white" x-data="{openMenuM:false}" :class="{'overflow-hidden':openMenuM}">
    @if (!Request::is('verify-email'))
        <header class="bg-white px-5 sticky top-0 z-50  md:flex md:justify-between" :class="{'min-h-screen flex flex-col':openMenuM}">
            <a href="https://findarotation.com/" class="logo items-center flex"> <x-icons.logo/></a>
            {{--  menu mobile  --}}
            <button type="button" class="inline-flex justify-between items-center absolute md:hidden" id="menu-mobile" aria-expanded="true" aria-haspopup="true"  @click="openMenuM = ! openMenuM">
                <img src="{{ Auth::user()->photo()}}" alt="userprofile" class="profile-img"/>
                <x-icons.carot-down x-show="!openMenuM"/>
                <x-icons.carot-up x-show="openMenuM"/>
            </button>
            <div class="right-side flex items-center justify-center">
                <div class="profile elative inline-block text-left items-center flex"  x-data="{ open: false }" :class="{'profile-shadow' :open}">
                    <button type="button" class="inline-flex justify-end w-full items-center" id="menu-button" aria-expanded="true" aria-haspopup="true"  @click="open = ! open">
                        <p>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</p>
                        <x-icons.carot-down x-show="!open" width="20"/>
                        <x-icons.carot-up x-show="open"/>
                    </button>
                    <div class="origin-top-right absolute right-0 mt-2 w-56 menu bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1" x-show="open" @click.outside="open = false">
                        <div class="py-1">
                        <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
                        <a href="{{route('search')}}" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-1">Search for a Rotation</a>
                        <a href="{{route('profile')}}" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-4">My Profile Settings</a>

                        <form method="POST" action="{{ route('logout') }}" class="block ml-auto">
                            @csrf
                            <a href="{{ route('logout') }}" class="text-gray-700 block w-full text-left px-4 py-2 text-sm" onclick="event.preventDefault(); this.closest('form').submit();">
                                Log out
                            </a>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
            <div :class="{'block': openMenuM, 'hidden': ! openMenuM}" x-cloak class="px-4 block overflow-scroll border-t pt-4 mt-4 menu-mobile grow w-full">
                <div class="py-1">
                    <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
                    <a href="{{ route('search') }}" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-0">Search for a Rotation</a>
                    <a href="{{route('student-applications')}}" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-1">My Applications</a>
                    <a href="{{route('messages')}}" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-2">View Messages</a>
                    <a href="{{route('documents')}}" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-4">My Documents</a>
                    <a href="{{route('profile')}}" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-3">Profile Settings</a>
                    <form method="POST" action="{{ route('logout') }}" class="block ml-auto">
                        @csrf
                        <a href="{{ route('logout') }}" class="text-gray-700 block w-full text-left px-4 py-2 text-sm" onclick="event.preventDefault(); this.closest('form').submit();">
                            Log out
                        </a>
                    </form>
                    </div>
            </div>
        </header>
    @endif

    <content class="container">
        {{ $slot }}
    </content>

    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
<footer>
    <div class="w-full px-2">
        <div class="md:flex justify-between items-center">
            <x-icons.logo color="#fff" width="120" />
            <div class="txt">
                2022. All rights reserved. | <a class="link ml-2" href="/terms">Terms & Conditions</a> | Copyright © Find a Rotation
            </div>
        </div>
    </div>
</footer>

</html>
