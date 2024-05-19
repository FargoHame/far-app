<p>Dear {{ $application->student->first_name }},</p>

<p>This is regarding your application for a rotation at {{ $application->rotation->hospital_name }}.</p>

<p>Your application status is now: {{ $application->status }}.</p>

<p><a href="{{ route('student-application-view',['application' => $application]) }}">Please click here to view the application.</a></p>

<p>--<br/>
The Find a Rotation team</p>