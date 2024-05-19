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
    <script src="https://www.dwin1.com/79928.js" type="text/javascript" defer="defer"></script>

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
    <!-- End Google Tag Manager (noscript) -->
    <script src="https://use.fontawesome.com/71d4d89223.js"></script>
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

</head>

<body class="bg-white" x-data="{openMenuM:false}" :class="{'overflow-hidden':openMenuM}">
    @if (!Request::is('verify-email'))
        <header class="bg-white px-5 sticky top-0 z-50  md:flex md:justify-between" :class="{'min-h-screen flex flex-col':openMenuM}">
            <a href="https://findarotation.com/" class="logo items-center flex"> <x-icons.logo/></a>
            {{--  menu mobile  --}}
            <button type="button" class="inline-flex justify-between items-center absolute md:hidden" id="menu-mobile" aria-expanded="true" aria-haspopup="true"  @click="openMenuM = ! openMenuM">
                <img src="{{ asset('images/blank-profile.png') }}" alt="userprofile" class="profile-img"/>
                <x-icons.carot-down x-show="!openMenuM"/>
                <x-icons.carot-up x-show="openMenuM"/>
            </button>
            <div class="right-side flex items-center justify-center">
                {{--  <div class="notifications flex">
                    <a href="{{route('messages')}}"><x-icons.message-notification dot=true/></a>
                    <div class="bell" x-data="{notification:false}" aria-expanded="true" aria-haspopup="true">
                        <span @click="notification=!notification"><x-icons.bell dot=true/></span>
                        <div class="noti bg-white origin-top-right absolute" x-show="notification" @click.outside="notification = false">
                            <div class="header flex justify-between">
                                <h4>Notifications</h4> <a href="#">View All</a>
                            </div>  --}}
                            {{--  flex items-center only if there is no notification  --}}
                            {{--  <div class="body justify-center">
                                <div class="notification flex justify-between">
                                    <div class="dot"></div>
                                    <div class="title">
                                        <p>Your application was rejected by “Radiology at Chicago Telerad, PLLC”</p>
                                        <div class="date">Yesterday, at 10:43 am</div>
                                    </div>
                                    <x-icons.close with="10" height="10"/>
                                </div>
                                <div class="notification flex justify-between">
                                    <div class="dot"></div>
                                    <div class="title">
                                        <p>Your application was rejected by “Radiology at Chicago Telerad, PLLC”</p>
                                        <div class="date">Yesterday, at 10:43 am</div>
                                    </div>
                                    <x-icons.close with="10" height="10"/>
                                </div>
                                <div class="notification flex justify-between">
                                    <div class="dot"></div>
                                    <div class="title">
                                        <p>Your application was rejected by “Radiology at Chicago Telerad, PLLC”</p>
                                        <div class="date">Yesterday, at 10:43 am</div>
                                    </div>
                                    <x-icons.close with="10" height="10"/>
                                </div>
                                <div class="notification flex justify-between">
                                    <div class="dot"></div>
                                    <div class="title">
                                        <p>Your application was rejected by “Radiology at Chicago Telerad, PLLC”</p>
                                        <div class="date">Yesterday, at 10:43 am</div>
                                    </div>
                                    <x-icons.close with="10" height="10"/>
                                </div>
                                <div class="notification flex justify-between">
                                    <div class="dot"></div>
                                    <div class="title">
                                        <p>Your application was rejected by “Radiology at Chicago Telerad, PLLC”</p>
                                        <div class="date">Yesterday, at 10:43 am</div>
                                    </div>
                                    <x-icons.close with="10" height="10"/>
                                </div>
                                <div class="notification flex justify-between">
                                    <div class="title">
                                        <p>Your application was rejected by “Radiology at Chicago Telerad, PLLC”</p>
                                        <div class="date">Yesterday, at 10:43 am</div>
                                    </div>
                                    <x-icons.close with="10" height="10"/>
                                </div>  --}}
                                {{--  <x-icons.notification-empty/>  --}}
                            {{--  </div>
                            <div class="footer flex justify-between items-center">
                                <a href="#"><x-icons.close/> Archive All</a>
                                <a href="{{route('profile')}}"><x-icons.setting/> Settings</a>
                            </div>
                        </div>
                    </div>
                </div>  --}}
                <div class="profile elative inline-block text-left items-center flex"  x-data="{ open: false }" :class="{'profile-shadow' :open}">
                    <button type="button" class="inline-flex justify-between w-full items-center" id="menu-button" aria-expanded="true" aria-haspopup="true"  @click="open = ! open">
                        <img src="{{ Auth::user()->photo() }}" alt="userprofile" class="profile-img"/>
                        <p>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</p>
                        <x-icons.carot-down x-show="!open" width="20"/>
                        <x-icons.carot-up x-show="open"/>
                    </button>
                    <div class="origin-top-right absolute right-0 mt-2 w-56 menu bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1" x-show="open" @click.outside="open = false">
                        <div class="py-1">
                        <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
                        <a href="{{ route('preceptor-rotations') }}" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-0">Manage Rotations</a>
                        <a href="{{route('messages')}}" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-1">View Messages</a>
                        <a href="{{route('profile')}}" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-4">Profile Settings</a>
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
                    <a href="{{ route('preceptor-rotations') }}" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-0">Manage Rotations</a>
                    <a href="{{route('messages')}}" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-2">View Messages</a>
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
    <div class="px-2 w-full">
        <div class="md:flex justify-between items-center">
            <x-icons.logo color="#fff" width="120" />
            <div class="txt">
                2022. All rights reserved. | <a href="/terms" class="link">Terms & Conditions</a> | Copyright © Find a Rotation
            </div>
        </div>
    </div>
</footer>

</html>
