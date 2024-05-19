<x-app-layout>
    <!-- Metadata -->
    @section ('title', 'Find a Rotation')
    @section ('description', 'View rotation')

    <link rel="stylesheet" href="{{ asset('css/lightbox.min.css') }}">

    <!-- Code -->
    <div class="mx-auto w-full max-w-4xl px-4 pt-5 view-rotation" x-data="{dialog:@error('availabilities') true  @else false @enderror,success: '{{$finished}}'}" id="container">

        @if (session('updateDocumentsError'))
            <p class="bg-red-300 text-white p-4 mb-4">{{ session('updateDocumentsError') }}</p>
        @endif
        <div class="p-4 mb-6">
            <div class="md:grid grid-cols-2 gap-4">
                <div>
                    <section class="splide mb-2" data-splide='{"arrows":true}'>
                        <div class="splide__track">
                              <ul class="splide__list">
                                  @if (count($rotation->images) > 0)
                                    @foreach($rotation->images as $image)
                                        <li class="splide__slide"><div class="slide-img" style="background-image: url({{ $image->path }})"></div></li>
                                    @endforeach
                                    @else
                                    <li class="splide__slide"><div class="slide-img" style="background-image: url({{ \App\Models\User::where(['id' => $rotation->preceptor_user_id])->firstOrFail()->photo() }})"></div></li>
                              @endif
                              </ul>
                        </div>
                      </section>
                </div>
                <div>
                    <p class="text-3xl font-semibold mb-1">{{ $rotation->preceptor_name }}</p>
                    <p class="mb-2 text-sm gray-font">{{ $rotation->specialtyNames() }}</p>
                    <p class="mb-0 text-sm gray-font">{{ $rotation->hospital_name }}</p>
                    @if (count($rotation->student_types) > 0)
                        <p class="mb-0 text-sm gray-font">Student Type: <span class="font-semibold">{{$rotation->student_types[0]->name}}</span></p>
                    @endif
                    <div class="location flex border-b py-3"><x-icons.location/> {{ $rotation->city }}, {{ $rotation->state }}</div>
                    <div class="flex items-center pt-5">
                        <b class="text-2xl">${{ $rotation->price_per_week_in_cents/100 }}</b>
                        @auth
                            <a href="/messages?rotation={{$rotation->id}}" class="btn-link btn-gray text-white px-5 py-3">Message</a>
                            <a href="#" class="btn-link btn-green px-8 py-3" @click="dialog=!dialog">Apply now</a>
                        @else
                            <a href="{{ route('register') }}" class="btn-link btn-gray text-white px-5 py-3">Message</a>
                            <a href="{{ route('register') }}" class="btn-link btn-green px-8 py-3">Apply now</a>
                        @endauth
                    </div>
                </div>
            </div>
            <div class="tabs mt-5" x-data="{tab:'desc'}">
                <div class="tab-header md:flex">
                    <h3 :class="{'active':tab=='desc'}" @click="tab='desc'">Main Description</h3>
                    <h3 :class="{'active':tab=='sch'}" @click="tab='sch'">Schedule</h3>
                    <h3 :class="{'active':tab=='req'}" @click="tab='req'">Requirements</h3>
                </div>
                <div class="tab-body">
                    <div class="content" :class="{'content-show': tab=='desc'}">
                        <b class="mb-3 inline-block">Description</b>
                        <p><?php echo $rotation->description ?></p>
                    </div>
                    <div class="content" :class="{'content-show': tab=='sch'}">
                        <b class="mb-3 inline-block">Calendar</b>
                        @php
                            $lastYear = '';
                            $lastMonth = '';
                        @endphp

                        @foreach($rotation->availabilty()->where(['status' => 'enabled'])->where('starts_at','>',\Carbon\Carbon::now())->orderBy('starts_at','ASC')->get() as $availability)
                            <div>
                                <h3 class="text-lg font-bold mb-5 mt-3">{{ ($lastYear !=$availability->starts_at->format('Y'))?$availability->starts_at->format('Y'):'' }}</h3>
                                <h4 class="text-sm font-bold mb-2">{{ ($lastMonth!=$availability->starts_at->format('M'))?$availability->starts_at->format('M'):'' }}</h4>
                                <div class="gray-box">{{ $availability->starts_at->format('M d') }} - {{ $availability->starts_at->copy()->addDays(6)->format('M d') }}</div>
                            </div>
                            @php
                                $lastYear = $availability->starts_at->format('Y');
                                $lastMonth = $availability->starts_at->format('M');
                            @endphp
                        @endforeach
                    </div>
                    <div class="content" :class="{'content-show': tab=='req'}">
                        @if (count($rotation->file_types) > 0)
                            <span class="mb-2 text-black block">You must complete these in order to reserve:</span>
                            <ul>
                                @foreach($rotation->file_types as $fileType)
                                <li class="flex items-center text-sm mb-5"><x-icons.document/><b class="ml-2">{{ $fileType->name }}</b></li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true" x-show="dialog" @click.outside="dialog = false">
          <div class="fixed inset-0 bg-black-trans bg-opacity-75 transition-opacity"></div>
            <div class="fixed inset-0 z-10 overflow-y-auto" style="top: 80px">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div>
                                <h2 class="text-xl font-bold text-center">Send an Application</h2>
                                <div class="mt-4">
                                    @error('availabilities')
                                        <div class="text-red-600">Please select the weeks you are interested in on the left.</div>
                                    @enderror
                                </div>
                                <b class="text-sm">Weeks available</b>
                                <table class="w-full">
                                    <tr class="font-bold">
                                        <td></td>
                                        <td></td>
                                        <td class="text-right pb-2"></td>
                                        <td class="text-center pb-2"></td>
                                    </tr>
                                    @php
                                        $lastYear = '';
                                        $lastMonth = '';
                                    @endphp

                                    @foreach($rotation->availabilty()->where(['status' => 'enabled'])->where('starts_at','>',\Carbon\Carbon::now())->orderBy('starts_at','ASC')->get() as $availability)
                                        <tr>
                                            <td class="text-lg font-bold">{{ ($lastYear !=$availability->starts_at->format('Y'))?$availability->starts_at->format('Y'):'' }}</td>
                                            <td class="text-sm font-bold">{{ ($lastMonth!=$availability->starts_at->format('M'))?$availability->starts_at->format('M'):'' }}</td>
                                            <td class="text-center pr-4 ">
                                                <div class="p-3 gray-box">
                                                    <span class="mr-2">{{ $availability->starts_at->format('M d') }} - {{ $availability->starts_at->copy()->addDays(6)->format('M d') }}</span>
                                                    @auth
                                                        @if ($availability->availableSeats() > 0 )
                                                            <input type="checkbox" class="week" value="{{ $availability->id }}" x-text="{{ $availability->starts_at->format('M d, Y') }} - {{ $availability->starts_at->copy()->addDays(6)->format('M d, Y') }}" />
                                                        @else
                                                            Full
                                                        @endif
                                                        @else
                                                        <td>{{ $availability->availableSeats() > 0 ? 'Available':'Full' }}</td>
                                                    @endauth
                                                </div>
                                            </td>
                                        </tr>
                                        @php
                                            $lastYear = $availability->starts_at->format('Y');
                                            $lastMonth = $availability->starts_at->format('M');
                                        @endphp
                                    @endforeach
                                </table>
                                <div class="mt-4">
                                    <b class="text-sm">Total cost</b>
                                    <div class="cost">None</div>
                                </div>
                                <form method="POST" action="{{ route('student-rotation-apply') }}" enctype='multipart/form-data'>
                                    @csrf
                                    <input type="hidden" name="rotation_id" value="{{ $rotation->id }}" />
                                    <div class="weeks"></div>
                                    <b class="text-sm">Message</b>
                                    <textarea id="message" name="message" rows="10" class="ckeditor block mt-1 w-full"></textarea>
                                    <b class="text-sm mt-4 mb-2 block">Required Documents</b>
                                    <div class="rotations">
                                        <ul class="box-doc">
                                            @auth
                                                @foreach($rotation->file_types as $fileType)
                                                    <li class="bg-greenlight rounded-md green-font mb-2">
                                                        <div for="file_{{ $fileType->id }}" class="flex px-3 items-center justify-between boxlist">
                                                            <div class="flex">
                                                                <span><x-icons.clip/></span> 
                                                                <p>{{ $fileType->name }}</p>
                                                            </div>
                                                            <div class="close"><x-icons.close color="#3ab8b9" height="12" width="12"/></div>
                                                        </div>
                                                        <div class="py-2 px-8 hidden list bg-greenDark">
                                                            <ul>
                                                                <li>
                                                                    <label for="file_{{ $fileType->id }}" class="flex">
                                                                        Upload file
                                                                        <input name="file_{{ $fileType->id }}" type="file" 
                                                                         {{--  {{ Auth::user()->files()->where(['file_type_id' => $fileType->id, 'is_manageable' => 1])->count()== 0 ? 'required' : ''}}   --}}
                                                                         id="file_{{ $fileType->id }}">
                                                                    </label>
                                                                </li>
                                                                @foreach ($files as $file )
                                                                    <li class="sublist" data-id="{{$fileType->id}}" data-value="{{$file->id}}">{{$file->type->name}}</li>
                                                                @endforeach
                                                                <li>
                                                                    <input name="file_saved{{ $fileType->id }}" type="hidden" id="file_saved{{ $fileType->id }}">
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            @endauth
                                        </ul>
                                    </div>
                                    <div id='required' class="text-sm text-red-600"></div>
                                    <div class="px-4 py-3 flex">
                                        <button type="button" class="btn w-full mr-3 btn-gray" @click="dialog=!dialog">Cancel</button>
                                        <button type="submit" class="btn w-full mr-3 btn-green" style="font-size: 12px" id="apply">Apply</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--  success alert  --}}
        <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true" x-show="success" @click.outside="success = false">
            <div class="fixed inset-0 bg-black-trans bg-opacity-75 transition-opacity"></div>
                <div class="fixed inset-0 z-10 overflow-y-auto" style="top: 80px">
                    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                      <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-xs">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <img src="{{ \App\Models\User::where(['id' => $rotation->preceptor_user_id])->firstOrFail()->photo() }}" class="img-success"/>
                                <h2 class="text-lg font-bold text-center mb-2">Your application has been sent!</h2>
                                <p class="text-center text-xs gray-font">Your application was submitted successfully. The preceptor will be in touch with you.</p>
                                <x-button-full @click="success=false"><span class="font-normal text-sm">Ok</span></x-button-full>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('styles')
        <link href="{{ asset('css/splide.min.css') }}" rel="stylesheet">
    @endpush
    @push('scripts')
    <script src="{{ asset('js/lightbox-plus-jquery.min.js') }}"></script>
    <script src="{{ asset('js/splide.min.js') }}"></script>
    <script >

        $(document).ready(function() {
            new Splide( '.splide' ).mount();
            var price = {{ $rotation->price_per_week_in_cents }};
            //hide or show close icon
            $('.box-doc input').change(function(){
                $(this)[0].files.length
                if($(this)[0].files.length > 0){
                    $(this).parent().parent().parent().parent().parent().find('.close').css('display','block')
                }else{
                    $(this).parent().parent().parent().parent().parent().find('.close').removeAttr( 'style' );
                }
                $(this).parent().parent().parent().parent().toggle('slow')
                $(this).parent().parent().parent().parent().find('li').removeAttr('style')
                $(this).parent().css('color','black')
                $(this).parent().parent().parent().find('input[type=hidden]').val('')
            })
            //check required fields
            /*$('#apply').click(function(){
                var isValid=true
                $('.rotations input:required').each(function(){
                    if($(this).val()===''){
                        {{--  debugger  --}}
                        isValid=false
                    }
                })
                if(!isValid){
                    $('#required').text('Please upload all the files required.')
                }
            })*/
            //open select list
            $('.boxlist').click(function(){
                $(this).parent().find('.list').toggle('slow')
            })
            //add value to hidden field
            $('.sublist').click(function(){
                const data = $(this).attr('data-value');
                $(this).parent().find('.sublist').css('color','inherit')
                $('#file_saved'+$(this).attr('data-id')).val(data)
                $(this).parent().parent().parent().find('.list').toggle('slow')
                $(this).parent().parent().parent().find('.close').css('display','block')
                $(this).css('color','black')
            })
            //clear file input
            $('.close').click(function(){
                $(this).parent().parent().find('input').val('')
                $(this).removeAttr( 'style' )
                $(this).parent().parent().find('li').css('color','inherit')
                $(this).parent().parent().find('label').css('color','inherit')
            })

            $(".week").change(function() {
                $(this).parent().css('border-color',$(this).is(":checked") ? '#3ab8b9' : 'rgb(0 0 0 / 0.1)')
                var total = 0;
                $(".weeks").text("");
                $(".week").each(function() {
                    if ($(this).is(":checked")) {
                        //$(".weeks").append("<p>" + (total + 1) +". " + $(this).attr("x-text") +"</p>");
                        $(".weeks").append('<input type="hidden" value="' + $(this).attr('value') +'" name="availabilities[]" />');
                        total++;
                    }
                });
                if (total==0) {
                    $(".weeks").text("None");
                    $(".cost").text("None");
                } else {
                    var totalPrice = (price * total)/100;
                    $(".cost").html("<b>$"+totalPrice.toFixed(2) + "</b> (" + total+ " weeks at $" + (price/100) +"/week)");
                }


            });
        });
    </script>
    <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.ckeditor').ckeditor();
        });
</script>
    @endpush
</x-app-layout>
