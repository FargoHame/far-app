<p>Dear {{ $preceptor->first_name }},</p>

<p>{{ $student->name() }} has paid for your rotation at {{ $application->rotation->hospital_name }}.</p>

<p><a href="{{ route('preceptor-application-view',['application' => $application]) }}">Please click here to view the application.</a></p>

<p>--<br/>
The Find a Rotation team</p>