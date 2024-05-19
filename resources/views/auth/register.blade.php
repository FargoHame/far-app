<x-app-layout>
    <!-- Metadata -->
    @section ('title', 'Sign up | Find a Rotation')
    @section ('description', 'Sign up for Find a Rotation')



    <x-auth-authentication-card>
        <div class="space"></div>
        <div class="user-type">
            <div class="user active-left user-selector">As a Student</div>
            <div class="user user-selector">As a Preceptor</div>
        </div>
        <x-social-login/>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors"/>
        @if (session('oauth-error') !== null)
            <x-alert title='Register Error' message="{{session('oauth-error')}}" type="error"></x-alert>
        @endif
        <form method="POST" action="{{ route('register') }}" x-data="{ role: 'student' }">
            @csrf

            <!-- Role -->
            <div style="display: none">
                <x-label for="role" :value="__('I am a')"/>
                <x-select x-model="role" id="role" class="block mt-1 w-full" type="text" name="role"
                          :value="old('role')" :values="['student' => 'Student', 'preceptor' => 'Preceptor']" required
                          autofocus/>
            </div>
            <!-- Name -->
            <div class="group flex items-center justify-between">
                <div class="mt-4 field-container">
                    <x-label for="first_name" :value="__('First name')"/>
                    <x-input id="first_name" class="block mt-1 w-full input-field" type="text" name="first_name"
                             :value="old('first_name')" required autofocus/>
                </div>
                <div class="mt-4 field-container">
                    <x-label for="last_name" :value="__('Last name')"/>
                    <x-input id="last_name" class="block mt-1 w-full input-field" type="text" name="last_name"
                             :value="old('last_name')" required autofocus/>
                </div>
            </div>
            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('E-mail')"/>
                <x-input id="email" class="block mt-1 w-full input-field" type="email" name="email"
                         :value="old('email')" required/>
            </div>

            <!-- School -->
            <div class="mt-4" x-show="role == 'student'">
                <x-label for="school" :value="__('School')"/>
                <x-autocomplete name="school" id="school" autocompleteRoute="schools-autocomplete"
                                :value="old('school')"></x-autocomplete>
            </div>
            <div class="mt-4" x-show="role == 'student'">
                <x-label for="career" :value="__('Career')"/>
                <x-select id="career" name="career"
                          :values="\App\Models\Career::getCareers()"
                          class="block w-full" value="old('career')"/>
            </div>
            <div class="mt-4" x-show="role == 'student'">
                <x-label for="studentType" :value="__('Student Type')"/>
                <x-select id="studentType" name="studentType"
                          :values="\App\Models\StudentTypePerCareer::getStudentTypePerCareersArray(1)"
                          class="block w-full" />
            </div>
            {{--  <div class="mt-4" x-show="role == 'student'">
                <x-label for="degree" :value="__('Degree')"/>
                <x-select id="degree" name="degree"
                          :values="['Pre-med' => 'Pre-med','Medical Student MD/DO' => 'Medical Student MD/DO', 'Medical Graduate MD/DO' => 'Medical Graduate MD/DO']"
                          class="block w-full" value="old('degree')"/>
            </div>  --}}
            <div class="group flex items-center justify-between">
                <div class="mt-4 field-container">
                    <x-label for="referral_code" :value="__('Referral code')"/>
                    <x-input id="referral_code" value="{{ isset($_GET['r']) ? $_GET['r'] : ''}}" class="block mt-1 w-full input-field"
                             type="text" name="referral_code" autofocus/>
                </div>

            </div>
            <div class="group flex items-center justify-between">
                <!-- Password -->
                <div class="mt-4 field-container">
                    <x-label for="password" :value="__('Password')"/>
                    <x-input id="password" class="block mt-1 w-full input-field" type="password" name="password"
                             required autocomplete="new-password" isPassword=true/>
                </div>

                <!-- Confirm Password -->
                <div class="mt-4 field-container">
                    <x-label for="password_confirmation" :value="__('Confirm password')"/>
                    <x-input id="password_confirmation" class="block mt-1 w-full input-field" type="password"
                             name="password_confirmation" required isPassword=true/>
                </div>
            </div>
            <!-- terms/ conditions -->
            <div class="flex md:flex-row flex-col md:items-center justify-around mt-4">
                <label for="terms" class="inline-flex items-center">
                    <input id="terms" type="checkbox"
                           class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                           name="terms">
                    <span class="ml-2 text-sm">{{ __('I accept') }}<a href="#" class="forgot">Terms</a> and <a href="#"
                                                                                                               class="forgot">conditions</a></span>
                </label>
            </div>
            <div class="block mt-4">
                <button class="w-full px-6 py-2 bg-far-green-dark hover:opacity-75 btn">
                    {{ __('Sign Up') }}
                </button>
            </div>
        </form>
    </x-auth-authentication-card>
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
