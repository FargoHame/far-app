Dear {{ $preceptor->first_name }},

{{ $student->first_name }} {{ $student->last_name }} has submitted a new application for your rotation at {{ $application->rotation->hospital_name }}.

You can click here to view the application: {{ route('preceptor-application-view',['application' => $application]) }}

--
The Find a Rotation team
