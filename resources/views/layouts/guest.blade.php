<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Metadata: Information -->
    <title>@yield('title', 'Find a Rotation')</title>
    <meta name="description" content="@yield('description')">
    <meta property="og:title" content="@yield('title', 'Find a Rotation')" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />
    <meta property="og:description" content="@yield('description')" />
    <meta property="og:image" content="{{ asset('images/og-default.jpg') }}" />

    <!-- Metadata: Other -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@500&family=Inter:wght@300;400;500;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

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
    @stack('styles')
</head>

<body x-data="{ sm_open:false, open: false }" :class="{'overflow-hidden':sm_open}" class="@if(!Request::is('login')&& !Request::is('register')  && !Request::is('register-affiliate')) bg-white @else main-bg @endif">
    @if (!Request::is('login')&& !Request::is('register') && !Request::is('register-affiliate'))
    <header class="bg-white px-5 sticky top-0 z-50 flex justify-between">
        <a href="https://findarotation.com/" target="_blank" class="logo items-center flex"> <x-icons.logo/></a>
        <div class="flex items-center flex-col md:flex-row">
            <a href="{{ route('login') }}" class="btn-link-trans">Log in</a>
            <a href="{{ route('register') }}" class="btn-link-green">Sign up</a>
        </div>
    </header>
    @endif

    <content>
        {{ $slot }}
    </content>
    @if (!Request::is('login')&& !Request::is('register')  && !Request::is('register-affiliate'))
    <footer>
        <div class="px-2 w-full">
            <div class="md:flex justify-between items-center">
                <x-icons.logo color="#fff" width="120" />
                <div class="txt">
                    <a href="/register-affiliate" class="underline">Join Affiliate Program</a> | <a href="#" class="link">Privacy policy</a> | <a href="/terms" class="link">Terms & Conditions</a> | 2022. All rights reserved. | Copyright © Find a Rotation
                </div>
            </div>
        </div>
    </footer>
    @else
    <footer class="px-4 footer-authentication">
        <div class="max-w-screen-xl mx-auto">
            <div class="flex flex-row items-center justify-center">
                <div class="text-center">
                    <div class="text">Find a Rotation, 2022  |  <a href="#" class="link">Privacy policy</a>  <a href="/terms" class="link ml-2">Terms and Conditions</a> | <a href="/register-affiliate" class="link ml-2">Join Affiliate Program</a> </div>
                </div>
            </div>
        </div>
    </footer>
    @endif
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>

</html>
