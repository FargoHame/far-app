@foreach($messages as $message)
    <div class="flex mb-3 justify-end">
        <div class="mb-2 p-4 flex md:flex-row flex-col justify-between green-buble">
            <div class="md:w-320">
                <b class="text-sm">You</b>
                <p class="md:mt-0 mt-2 gray-font text-sm">@php echo $message->message; @endphp</p>
            </div>
            <p class="text-sm font-bold"><span class="green-font">{{ \Carbon\Carbon::parse($message->created_at)->diffForHumans() }}</span> <br/>{{ Carbon\Carbon::parse($message->created_at)->toFormattedDateString() }}</p>
        </div>
    </div>
@endforeach

