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

  @livewireStyles

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

<body x-data="{ sm_open:false, open: false }" :class="{'overflow-hidden':sm_open}" class="bg-white">
  <div class="min-h-screen flex flex-col">
    <!-- Page Heading -->
    <header class="bg-white drop-shadow px-2 py-4 sticky top-0 z-50"  :class="{'min-h-screen flex flex-col':sm_open}">
      <div class="flex flex-row items-center">
        <div class="sm:ml-0 -ml-2 mr-2 flex items-center sm:hidden">
            <button @click="sm_open = ! sm_open" class="inline-flex items-center justify-center p-2 rounded-md focus:outline-none">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': sm_open, 'inline-flex': ! sm_open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{'hidden': ! sm_open, 'inline-flex': sm_open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <a href="{{ route('admin-students') }}" class="font-black text-2xl uppercase">Find a Rotation</a>
        <form method="POST" action="{{ route('logout') }}" class="block ml-auto">
                @csrf
                <a href="{{ route('logout') }}" class="font-semibold mr-4" onclick="event.preventDefault(); this.closest('form').submit();">
                    Log out
                </a>
        </form>
      </div>

      <!-- Responsive Navigation Menu -->
      <div :class="{'block': sm_open, 'hidden': ! sm_open}" x-cloak class="px-4 block overflow-scroll border-t grow pt-4 mt-4 bg-far-green-light">
          <x-navigation-link route="admin-students" classes="text-lg">Students</x-navigation-link>
          <x-navigation-link route="admin-preceptors" classes="text-lg">Preceptors</x-navigation-link>
          <x-navigation-link route="admin-rotations" classes="text-lg">Rotations</x-navigation-link>
          <x-navigation-link route="admin-applications" classes="text-lg">Applications</x-navigation-link>
          <x-navigation-link route="admin-payments" classes="text-lg">Payments</x-navigation-link>
          <x-navigation-link route="profile" classes="text-lg">View profile</x-navigation-link>
          <x-navigation-link route="admin-careers" classes="text-lg">Careers</x-navigation-link>
          <x-navigation-link route="admin-students">Student Types</x-navigation-link>
      </div>
    </header>
    <div class="flex flex-1 w-screen">
      <div class="bg-far-green-light text-black w-56 pt-8 px-4 md:block hidden">
        <div class="flex flex-col">
          <x-navigation-link route="admin-students">Students</x-navigation-link>
          <x-navigation-link route="admin-preceptors">Preceptors</x-navigation-link>
          <x-navigation-link route="admin-rotations">Rotations</x-navigation-link>
          <x-navigation-link route="admin-applications">Applications</x-navigation-link>
          <x-navigation-link route="admin-payments">Payments</x-navigation-link>
          <x-navigation-link route="profile">View profile</x-navigation-link>
          <x-navigation-link route="admin-careers">Careers</x-navigation-link>
          <x-navigation-link route="admin-students">Student Types</x-navigation-link>
        </div>
      </div>
      <div class="flex-1 overflow-x-hidden">
        <!-- Page Content -->
        <main>
          {{ $slot }}
        </main>
      </div>
    </div>
  </div>
  @stack('modals')
  @livewireScripts
  <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
