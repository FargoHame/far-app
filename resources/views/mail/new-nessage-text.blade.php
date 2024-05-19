Dear {{ $send_to_user->first_name }},

{{ $m->user->name()}} has sent you a new message regarding the rotation at {{ $m->application->rotation->hospital_name }}.

{{ $m->message }}

You may click here to view the message: {{ route($send_to_user->role=='preceptor'?'preceptor-application-view':'student-application-view',['application' => $m->application]) }}

--
The Find a Rotation team