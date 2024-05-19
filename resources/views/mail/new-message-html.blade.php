<p>Dear {{ $send_to_user->first_name }},</p>

<p>{{ $m->user->name()}} has sent you a new message regarding the rotation at {{ $m->application->rotation->hospital_name }}.</p>

<p>{{ $m->message }}</p>

<p><a href="{{ route($send_to_user->role=='preceptor'?'preceptor-application-view':'student-application-view',['application' => $m->application]) }}">Please click here to view the message.</a></p>

<p>--<br/>
The Find a Rotation team</p>