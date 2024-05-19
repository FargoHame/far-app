<x-app-layout>
  @section ('title', "View messages")

  <div class="mx-auto w-full max-w-7xl px-4 pt-5">
        <div class="pb-4 mb-4">
             <div class="md:flex items-center">
                <h1 class="text-3xl font-bold">Messages</h1>
            </div>
        </div>

        @if(count($messages) > 0)
          @foreach($messages as $message)

          @if (Auth::user()->role == 'student')
          <a href="{{ route('student-application-view',['application' => $message->application]) }}">
          @else
          <a href="{{ route('preceptor-application-view',['application' => $message->application]) }}">
          @endif
            <div class="mb-5 message pr-5 pl-5 pt-8 pb-8 flex md:flex-row flex-col md:items-center">
              <div class="md:w-240 w-full">
                @if ($message->viewed_at == null)
                      <span class="bg-green px-2 py-1 mt-1 inline-block text-white rounded-md mb-1" style="font-size: 10px">New Message</span>
                      @php $message->viewed_at = now(); $message->save(); @endphp
                @endif
                @if (Auth::user()->role == 'student')
                  <p class="text-sm font-semibold mb-1">{{ $message->application->rotation->preceptor_name }}</p>
                  <p class="text-sm font-semibold">{{ $message->application->rotation->hospital_name }}</p>
                @else
                  <p class="text-xl font-semibold mb-1">{{ $message->application->rotation->hospital_name }}</p>
                  <p>{{ $message->application->rotation->city }}, {{ $message->application->rotation->state }}</p>
                @endif
              </div>

              <div class="flex-1 md:mt-0 mt-4">
                @if (Auth::user()->role == 'preceptor')
                  <p class="mb-1 md:ml-4 font-semibold">{{ $message->user->name() }}</p>
                @endif
                <p class="mb-2 md:ml-4 content">@php echo $message->message; @endphp</p>
              </div>
              <div>
                <p class="text-sm font-semibold">{{ $message->application->rotation->city }}, {{ $message->application->rotation->state }}</p>
                <p class="text-sm md:ml-4 font-semibold date">{{ $message->created_at->format('d M, Y') }}</p>
              </div>
            </div>
          </a>
          @endforeach

          {{ $messages->links() }}
        @else
          <p>You haven’t received any messages yet.</p>
        @endif
    </div>

</x-app-layout>
