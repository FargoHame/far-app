Dear {{ $application->student->first_name }},

This is regarding your application for a rotation at {{ $application->rotation->hospital_name }}.

Your application status is now: {{ $application->status }}.

You can click here to view your application: {{ route('student-application-view',['application' => $application]) }}

--
The Find a Rotation team