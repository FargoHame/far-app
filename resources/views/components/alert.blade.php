@props(['type','title','message'])
<div id="popup" class="popup">
    <div class="content">
        <div class="flex justify-center items-center">
            @if ($type=='success')
                <?xml version="1.0" ?><svg viewBox="0 0 24 24" width="50" height="50" xmlns="http://www.w3.org/2000/svg"><title/><path d="M12,2A10,10,0,1,0,22,12,10,10,0,0,0,12,2Zm4.71,7.71-5,5a1,1,0,0,1-1.42,0l-2-2a1,1,0,0,1,1.42-1.42L11,12.59l4.29-4.3a1,1,0,0,1,1.42,1.42Z" fill="#08f606"/></svg>
            @else
                <?xml version="1.0" ?><svg height="50px" version="1.1" viewBox="0 0 20 20" width="50px" xmlns="http://www.w3.org/2000/svg" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" xmlns:xlink="http://www.w3.org/1999/xlink"><title/><desc/><defs/><g fill="none" fill-rule="evenodd" id="Page-1" stroke="none" stroke-width="1"><g fill="red" id="Core" transform="translate(-2.000000, -212.000000)"><g id="error" transform="translate(2.000000, 212.000000)"><path d="M10,0 C4.5,0 0,4.5 0,10 C0,15.5 4.5,20 10,20 C15.5,20 20,15.5 20,10 C20,4.5 15.5,0 10,0 L10,0 Z M11,15 L9,15 L9,13 L11,13 L11,15 L11,15 Z M11,11 L9,11 L9,5 L11,5 L11,11 L11,11 Z" id="Shape"/></g></g></g></svg>
            @endif
        </div>
        <h2 class="mt-2">{{$title}}</h2>
        <p>{{$message}}</p>
        <div class="flex justify-center items-center">
            <button class="bg-slate-100 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-32 mt-4" id="btn-close">Close</button>
        </div>
    </div>
</div>

<script >
    var button_close = document.getElementById('btn-close');

    button_close.addEventListener('click', function() {
        let popup = document.getElementById('popup');
        popup.remove();
    }, false);
</script>
