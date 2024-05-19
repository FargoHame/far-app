Dear {{ $preceptor->first_name }},

{{ $student->name() }} has paid for your rotation at {{ $application->rotation->hospital_name }}.

You can click here to view the application: {{ route('preceptor-application-view',['application' => $application]) }}

--
The Find a Rotation team
