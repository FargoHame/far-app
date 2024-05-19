
@foreach($messages as $message)
    <div class="flex mb-3 justify-start">
            <img src="{{$message->user->profile_image!=null ? \App\Models\User::where(['id' => $message->user->id])->firstOrFail()->photo() : asset('/images/blank-profile.png')}}"/>
        <div class="mb-2 p-4 flex md:flex-row flex-col justify-between gray-buble">
            <div class="md:w-320">
                <b class="text-sm">{{ $message->user->name() }}</b>
                <p class="md:mt-0 mt-2 gray-font text-sm">@php echo $message->message; @endphp</p>
            </div>
            <p class="text-sm font-bold"><span class="green-font">{{ \Carbon\Carbon::parse($message->created_at)->diffForHumans() }}</span> <br/>{{ Carbon\Carbon::parse($message->created_at)->toFormattedDateString() }}</p>
        </div>
    </div>
@endforeach
