<div class="social-container">
    <div class="title">
        <hr/><span>Fast access with</span><hr/>
    </div>
    <div class="btns flex justify-center">
        <a href="{{route('auth')}}">
            <x-icons.doximity-btn/>
        </a>
        <a href="{{ route('auth', ['provider' => 'google']) }}">
            <x-icons.google-btn/>
        </a>
        <a href="{{ route('auth', ['provider' => 'linkedin']) }}">
            <x-icons.linkedin-btn/>
        </a>
    </div>
    <div class="or">
        <hr/><span>or</span><hr/>
    </div>
</div>