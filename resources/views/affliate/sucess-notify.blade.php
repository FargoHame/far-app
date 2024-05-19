<x-app-layout>
    @section ('title', "Successfully Associated Account")

    <div class="text-center mx-auto w-full max-w-4xl px-4 pt-5">
        <img width="60" src="{{asset('images/check.png')}}" class="center" style="margin: 0 auto"/>
        <br>
        <h2 class="text-2xl font-bold pb-3">An invitation email has been sent</h2>
        <a href="/" ><button class="btn btn-green min-w-200" >Home</button></a>
    </div>

</x-app-layout>
