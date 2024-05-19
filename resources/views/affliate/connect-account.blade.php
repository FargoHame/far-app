<x-app-layout>
    @section ('title', "Conect Account")

    <div class="mx-auto w-full max-w-4xl px-4 pt-5">

        @if($errors->any())
            @foreach ($errors->all() as $error)
                <p class="bg-red-300 text-white p-4 mb-4">{{$error}}</p>
            @endforeach
        @endif

        <h2 class="text-2xl font-bold pb-3">Connecting with Gigwage</h2>
        <form method="post" action="{{ route('connect-account-create') }}" enctype="multipart/form-data" class="filter pb-7">
            @csrf
            <div class="md:grid grid-col-2 grid-flow-col gap-5">
                  <div class="mt-4">
                      <x-label for="first_name" :value="__('First name')" style="font-size: 12px"/>
                      <x-input  id="first_name" name="first_name" class="gray-font block mt-1 w-full input-field" value="{{ Auth::user()->first_name }}" required />
                  </div>
                  <div class="mt-4">
                      <x-label for="last_name" :value="__('First name')" style="font-size: 12px"/>
                      <x-input  id="last_name" name="last_name" class="gray-font block mt-1 w-full input-field" value="{{ Auth::user()->last_name }}" required />
                  </div>
            </div>

            <div class="md:grid grid-col-2 grid-flow-col gap-5">
                <div class="mt-12">
                    <x-label for="email" :value="__('Email address')" style="font-size: 12px"/>
                    <x-input  id="email" name="email" class="gray-font block mt-1 w-full input-field" value="{{ Auth::user()->email }}" required />
                </div>
            </div>

            <div class="mt-3 text-right">
                <input  id="timestamp"  type="text" name="timestamp" class="gray-font block mt-1 w-full input-field hidden"  />
                <button id="save" type="submit" class="btn btn-green min-w-200" >Save changes</button>
            </div>
        </form>
    </div>
    @push('scripts')
        <script src="{{ asset('js/affliate.js') }}"></script>
        <script>
            $( "#save" ).on( "click ", function() {
                let timestamp = (new Date).getTime().toString();
                $("#timestamp" ).val(timestamp)
            });
        </script>
    @endpush
</x-app-layout>
