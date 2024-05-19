<x-app-layout>
  @section ('title', ($rotation->id ? 'Edit' : 'Add') . " rotation")

  <div class="mx-auto w-full max-w-4xl px-4 pt-5" x-data="{dialog:false}">
    <div class="md:flex justify-between">
        <h1 class="text-3xl font-bold">{{ $rotation->id ? 'Edit' : 'Add' }} Rotation</h1>
        <div class=" mb-4 flex justify-end">
            <a href="{{ url()->previous() }}" class="px-6 py-2 rounded-md btn-green text-white md:w-auto w-full text-center">Back</a>
        </div>
    </div>

      <h1 class="text-1xl font-bold pb-3 mt-7">Complete the required information</h1>

      <x-auth-validation-errors class="mb-6 bg-red-300 p-2" :errors="$errors" />

      <form method="post" action="{{ route('preceptor-rotation-update') }}"  enctype='multipart/form-data' id="form" class="filter">
        @csrf
        <input type="hidden" value="{{ $rotation->id }}" name="id" />
        <div class="md:grid grid-cols-2 gap-5">
          <div class="mt-4">
            <x-label for="preceptor_name" :value="__('Preceptor name')" style="font-size: 12px"/>
            <x-input id="preceptor_name" name="preceptor_name" class="gray-font block mt-1 w-full input-field text-sm" value="{{ $rotation->preceptor_name }}" required />
          </div>
          <div class="mt-4">
            <x-label for="hospital_name" :value="__('Hospital name')" style="font-size: 12px"/>
            <x-input id="hospital_name" name="hospital_name" class="gray-font block mt-1 w-full input-field text-sm" value="{{ $rotation->hospital_name }}" required />
          </div>
        </div>
        <div class="md:grid grid-cols-2 gap-5">
          <div class="mt-4">
            <x-label for="city" :value="__('City')" style="font-size: 12px"/>
            <x-autocomplete name="city" id="city" autocompleteRoute="cities-autocomplete" value="{{ $rotation->city }}"></x-autocomplete>
          </div>

          <div class="mt-4">
            <x-label for="state" :value="__('State')" style="font-size: 12px"/>
            <x-select id="state" name="state" :values="\App\Models\Rotation::getStates(false)" class="block mt-1 w-full" value="{{ $rotation->state }}" required />
          </div>
        </div>
        <div class="md:grid grid-cols-2 gap-5">
          <div class="mt-4">
            <x-label for="zipcode" :value="__('Zipcode')" style="font-size: 12px"/>
            <x-input id="zipcode" name="zipcode" class="gray-font block mt-1 w-full input-field text-sm" value="{{ $rotation->zipcode }}" required />
          </div>

          <div class="mt-4">
            <x-label for="type" :value="__('Rotation type')" style="font-size: 12px"/>
            <x-select id="type" name="type" :values="\App\Models\Rotation::TYPES" class="block mt-1 w-full" value="{{ $rotation->type }}" required />
          </div>
        </div>
        <div class="md:grid grid-cols-2 gap-5 pb-6" style="border-bottom: 1px solid rgba(165, 165, 165, 0.4)">
          <div class="mt-4 col-span-1">
            <x-label for="specialties" :value="__('Specialty')" style="font-size: 12px"/>
            <p class="text-red-600" id="specialties_error" style="display:none">{{"You've"}} selected duplicated specialties.</p>
            <div class="specialty_template text-right mb-5">
              <x-select id="specialties" name="specialties[]" :values="$specialties" class="block mt-1 w-full specialty"  required />
              <a href="#" class="text-sm remove">Remove</a>
            </div>
            <div class="specialties mb-2">
              @foreach($rotation->specialties as $specialty)
              <div class="specialty_template text-right mb-5">
                <x-select id="specialties" name="specialties[]" :values="$specialties" class="block mt-5 w-full specialty"  :value="$specialty->id" required />
                <a href="#" class="text-sm remove">Remove</a>
              </div>
              @endforeach
            </div>
            <div class="w-full">
              <a href="#" class="add_more_specialties green-font">+ Add more specialties</a>
            </div>
          </div>

          <div class="mt-4 col-span-1">
            <x-label for="price_per_week_" :value="__('Price per week')" style="font-size: 12px"/>
            <div class="flex flex-wrap items-stretch w-full mb-4 relative">
              <x-input id="price_per_week" name="price_per_week" class="flex-1 gray-font block w-full input-field text-sm pl-5" value="{{ $rotation->price_per_week_in_cents/100 }}" required />
                <span class="gray-font absolute top-2 left-2">$</span>
            </div>

          </div>
        </div>
        <h1 class="text-1xl font-bold pb-3 mt-7">Main description</h1>
        <div class="mt-4 pb-8" style="border-bottom: 1px solid rgba(165, 165, 165, 0.4)">
          <textarea id="description" name="description" rows="8" class="ckeditor gray-font block mt-1 w-full input-field text-sm" style="height: 200px;border-radius: 15px">{{ $rotation->description}}</textarea>
        </div>

        <div class="mt-4" style="border-bottom: 1px solid rgba(165, 165, 165, 0.4)">
          <h1 class="text-1xl font-bold pb-3 mt-7">{{__('Documents required')}}</h1>
          <ul class="columns-3" id="documents">
            @foreach($file_types as $fileType)
              @if($fileType->user_id == null  || $fileType->user_id == Auth::user()->id)
                <li class="mb-2"><input type="checkbox" class="checkbox mr-1" value="{{$fileType->id}}" id="file-{{$fileType->id}}" name="file_types[]" {{ $rotation->file_types()->where(['file_type_id' => $fileType->id])->count() > 0 ? 'checked':'' }}> <label for="file-{{$fileType->id}}">{{$fileType->name }}</span></li>
              @endif
            @endforeach
          </ul>
          <span class="btn btn-green  mb-5 inline-flex justify-center items-center cursor-pointer" style="font-weight: normal; height: 30px;font-size: 14px;min-width: 100px;"  @click="dialog=!dialog">Add New</span>
        </div>
        <div class="mt-4" style="border-bottom: 1px solid rgba(165, 165, 165, 0.4)">
          <div class="mt-4">
            <x-label for="career" :value="__('Career')"/>
            <x-select id="career" name="career" :values="\App\Models\Career::getCareers()" class="block w-full" value="{{ count($rotation->student_types) > 0 ? $rotation->student_types[0]->career_id :'' }}"/>
          </div>
          <div class="mt-4">
            <x-label for="studentType" :value="__('Student Type')"/>
            <x-select id="studentType" name="studentType" :values="\App\Models\StudentTypePerCareer::getStudentTypePerCareersArray(1)" class="block w-full" />
          </div>
        </div>
        <h1 class="text-1xl font-bold pb-3 mt-7">Select Images (Optional)</h1>
        <div class="mt-4">
          <div class="removed_files"></div>
          <div class="image_template mb-2">
            <input class="inline-block mt-2" name="images[]" type="file" />
            <a href="#" class="text-sm remove">Remove</a>
          </div>
          <div class="images mb-2">
            <div class="image_template flex items-center">
            @foreach($rotation->images as $image)
             <div class="flex flex-col items-center mr-4">
              <img class="w-24 rounded-full mb-2" src="{{ $image->path}}" />
              <a href="#" class="text-sm remove ml-4 red-font" data-id="{{ $image->id }}">Remove</a>
             </div>
            @endforeach
          </div>
          </div>
          <div class="w-full">
            <a href="#" class="add_another_image green-font">+ Add another image</a>
          </div>
        </div>

        <div class="my-3">
          <button type="submit" class="btn btn-green min-w-200" style="font-weight: normal">Save changes</button>
        </div>
      </form>
      <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true" x-show="dialog" @click.outside="dialog = false" id="doc">
        <div class="fixed inset-0 bg-black-trans bg-opacity-75 transition-opacity"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto" style="top: 80px">
          <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
              <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                  <div>
                    <h2 class="text-xl font-bold text-center">Add New Document</h2>
                    <form class="filter" id="document-add" method="POST">
                      @csrf
                      <div class="mt-4">
                        <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id}}" />
                        <x-label for="doc-name" style="font-size: 12px" value="Document Name"/>
                        <x-input id="doc-name" name="doc-name" class="gray-font block mt-1 w-full input-field text-sm" required />
                      </div>
                      <div class="px-4 py-3 flex">
                        <button type="button" class="btn w-full mr-3 btn-gray" @click="dialog=!dialog">Cancel</button>
                        <button type="submit" class="btn w-full mr-3 btn-green" style="font-size: 12px" id="apply">Save</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
  </div>

  @push('scripts')
  <script >
    $(document).ready(function() {
      var specialty_template = $('.specialty_template:first').remove();

      if ($(".specialties .specialty_template").length==0) {
        $(".specialties").append(specialty_template.clone());
      }

      $(".add_more_specialties").click(function() {
        $(".specialties").append(specialty_template.clone());
        return false;
      });

      $(".specialties").on('click','.remove',function() {
        $(this).parent().remove();
        return false;
      });

      $(".specialties .specialty_template:first .remove").remove();


      var image_template = $('.image_template:first').remove();

      if ($(".images .image_template").length==0) {
        $(".images").append(image_template.clone());
      }

      $(".add_another_image").click(function() {
        $(".images").append(image_template.clone());
        return false;
      });

      $(".images").on('click','.remove',function() {
        var id = $(this).attr("data-id");
        $(".removed_files").append($('<input type="hidden" name="removed_images[]" value="' + id + '" />'));
        $(this).parent().remove();
        return false;
      });

      $("#form").submit(function() {
        var sp = {};
        var error = false;
        $(".specialty").each(function() {
          if (sp[$(this).val()]) {
            error = true;
          }
          sp[$(this).val()] = true;
        });

        if (error) {
          $("#specialties_error").show();

          $('html, body').animate({
            scrollTop: $("#specialties_error").offset().top - 100
          }, 100);

          return false;
        }
      });
      @php if (count($rotation->student_types) > 0 ){@endphp
        $("#studentType").empty()
        $.ajax({
          url:  '/student-type-career/'+@php echo $rotation->student_types[0]->career_id @endphp,
          method: 'get',
          success: function(result){
              result.data.forEach(val=>{
                  $("#studentType").append(new Option(val.name,val.id))
              })
              $("#studentType").val(@php echo $rotation->student_types[0]->id @endphp)
          },
          error: function(result){
              console.log(result);
          }
      })
      @php } @endphp
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
    });
    $(document).on('submit', '#document-add',
      function(data){
        data.preventDefault()
        name = $('#doc-name').val()
        user = $('#user_id').val()
        data.isJson = true
        $.ajaxSetup({
          headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        })
        $.ajax({
          url: "{{url('/preceptor/rotation/add-document')}}",
          method: 'post',
          data:{name,user},
          success: function(result){
            $('#documents').append('<li class="mb-2"><input type="checkbox" class="checkbox mr-1" value="'+result.file.id+'" id="file-'+result.file.id+'" name="file_types[]"> <label for="file-'+result.file.id+'">'+result.file.name+'</span></li>')
              $('#doc').css('display','none')
          },
          error: function(result){
          alert('Something went wrong. Please try again')
          }
        })
      }
    )
  </script>
  <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.ckeditor').ckeditor();
        });
    </script>

  @endpush
</x-app-layout>
