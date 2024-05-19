<x-app-layout>
    <!-- Metadata -->
    @section ('title', 'Sign up | Find a Rotation')
    @section ('description', 'Sign up for Find a Rotation')

    <x-auth-squard>
        <h1 class="font-black text-2xl mb-4 text-cente">Complete your registration</h1>
        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('finish-registration') }}" x-data="{ role: 'student' }" class="form-style">
            @csrf

            @if (str_ends_with(Auth::user()->email,'@temp.findarotation.com'))
            <div class="mt-4">
                <x-label for="email" :value="__('My email')" />
                <x-input id="email" class="input-field block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>
            @endif

            <div class="mt-4">
                <x-label for="role" :value="__('I am a')" />
                <x-select x-model="role" id="role" class="block w-full" type="text" name="role" :value="old('role')" :values="['student' => 'Student', 'preceptor' => 'Preceptor']" required autofocus />
            </div>

            <div class="mt-4" x-show="role == 'student'">
                <x-label for="school" :value="__('My school')" />
                <x-autocomplete name="school" id="school" autocompleteRoute="schools-autocomplete" :value="old('school')"></x-autocomplete>
            </div>
            <div class="mt-4" x-show="role == 'student'">
                <x-label for="career" :value="__('Career')"/>
                <x-select id="career" name="career"
                          :values="\App\Models\Career::getCareers()"
                          class="block w-full" value="old('career')"/>
            </div>
            <div class="mt-4" x-show="role == 'student'">
                <x-label for="studentType" :value="__('studentType')"/>
                <x-select id="studentType" name="studentType"
                          :values="\App\Models\StudentTypePerCareer::getStudentTypePerCareersArray(1)"
                          class="block w-full" />
            </div>
            <div class="flex items-center justify-center mt-4">
                <x-button class="w-full px-6 py-2 bg-far-green-dark hover:opacity-75 btn">
                    {{ __('Finish') }}
                </x-button>
            </div>
        </form>
    </x-auth-squard>
    @push('scripts')
        <script>
            $("#career").change(function(){
                let id =$(this).val()
                $("#studentType").empty()
                $.ajax({
                    url:  '/student-type-career/'+id,
                    method: 'get',
                    success: function(result){
                        result.data.forEach(val=>{
                            $("#studentType").append(new Option(val.name,val.id))
                        })
                    },
                    error: function(result){
                        console.log(result);
                    }
                })
            })
        </script>
    @endpush
</x-app-layout>