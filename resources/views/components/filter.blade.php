<div class="filter p-4 bg-white">
    <div class="clickOutSide hidden"></div>
    <div class="mx-auto w-full max-w-7xl px-4 pt-5">
        <form method="POST" action="{{ route('searchpost') }}">
            @csrf
            <div class="grid md:grid-cols-4 gap-5">
                <div>
                    <x-label>City or zip</x-label>
                    <x-autocomplete name="location" id="location" autocompleteRoute="cities-autocomplete"></x-autocomplete>
                </div>

                <div class="dropdown">
                    <button id="state" onclick="states()" class="dropbtn btn2 btn-green justify-between w-full items-center filter-input">State</button>
                    <div id="state-content" class="state-content filter-list">
                        <ul>
                        @foreach(\App\Models\Rotation::getStates() as $key => $value)
                            <li role="menuitem">
                                <label>
                                <input type="checkbox" class="checkbox" name="state[]" value="{{ $key }}" onclick="addOption('{{ $key }}')"> {{ $value }}
                                </label>
                            </li>
                        @endforeach
                        </ul>
                    </div>

                </div>
                <div class="dropdown">
                    <button id="speciality" onclick="specialities()" class="dropbtn btn2 btn-green justify-between w-full items-center filter-input">Specialty</button>
                    <div id="speciality-div" class="speciality-content filter-list">
                        <ul>
                        @foreach(\App\Models\Specialty::getSpecialties(true) as $key => $value)
                            <li role="menuitem">
                                <label>
                                <input type="checkbox" class="checkbox" name="specialty[]" value="{{ $key }}" onclick="addSpecialty('{{ $value }}',{{$key}})"> {{ $value }}
                                </label>
                            </li>
                        @endforeach
                        </ul>
                    </div>
                </div>
                <!-- <div>
                    <x-label>Specialty</x-label>
                    <x-select id="specialty" name="specialty" :values="\App\Models\Specialty::getSpecialties(true)" class="block mt-1 w-full" />
                </div> -->
                <div class="dropdown">
                    <button id="type" onclick="myFunction()" class="dropbtn btn2 btn-green justify-between w-full items-center filter-input">Type</button>
                    <div id="myDropdown" class="dropdown-content filter-list">
                        <ul>
                        @foreach(\App\Models\Rotation::TYPES as $key => $value)
                            <li role="menuitem">
                                <label>
                                <input type="checkbox" class="checkbox" name="type[]" value="{{ $key }}" onclick="addType('{{ $value }}')"> {{ $value }}
                                </label>
                            </li>
                        @endforeach
                        </ul>
                    </div>
                </div>
                <!-- <div class="profile elative inline-block text-left items-center flex"  x-data="{ open: false }" :class="{'profile-shadow' :open}">
                    <button type="button" class=" btn2 btn-green inline-flex justify-between w-full items-center" id="menu-button" aria-expanded="true" aria-haspopup="true"  @click="open = ! open">
                     Type
                    </button>
                    <div class="relative right-0 top-0 mt-2 w-56 menu bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1" x-show="open" @click.outside="open = false">
                        <div class="py-1">
                        < Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" >
                        <ul>
                        @foreach(\App\Models\Rotation::TYPES as $key => $value)
                            <li role="menuitem">
                                <label>
                                <input type="checkbox"> {{ $value }}
                                </label>
                            </li>
                        @endforeach
                        </ul>
                        </div>
                    </div>
                </div> -->

                <!-- <div class="dropdown">
                    <button class="btn btn-green w-full dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Type
                    </button>
                    <ul class="dropdown-menu allow-focus" aria-labelledby="dropdownMenuButton">
                    @foreach(\App\Models\Rotation::TYPES as $key => $value)
                        <li >
                            <label>
                            <input type="checkbox"> {{ $value }}
                            </label>
                        </li>
                    @endforeach
                    </ul>
                </div> -->
            </div>
            <div class="grid md:grid-cols-1 gap-1 mt-8 items-center">
                <div class="md:col-span">
                    <x-label>Price per week</x-label>
                    <input type="text" class="js-range-slider w-full" name="price_range" id="price_range"/>
                </div>
            </div>
            <div class="grid md:grid-cols-3 gap-5 mt-8 items-center">
                <div class="grid md:grid-cols-2 gap-5">
                    <div class="field-container">
                        <x-label>Start after</x-label>
                        <x-input name="start_after" type="date" class="input-field w-full" value="{{ request()->start_after }}" onchange="changeInputs(event.target.value, 'start_after')"></x-input>
                    </div>
                    <div class="field-container">
                        <x-label>End before</x-label>
                        <x-input name="end_before" type="date" class="input-field w-full" value="{{ request()->end_before }}" onchange="changeInputs(event.target.value, 'end_before')"></x-input>
                    </div>
                </div>
                <div class="grid md:grid-cols-2 gap-5">
                    <div class="field-container">
                        <x-label for="career" :value="__('Career')"/>
                        <x-select id="career" name="career" :values="\App\Models\Career::getCareers()" class="block w-full" value="old('career')"/>
                    </div>
                    <div class="field-container">
                        <x-label for="studentType" :value="__('Student Type')"/>
                        <x-select id="studentType" name="studentType" :values="\App\Models\StudentTypePerCareer::getStudentTypePerCareersArray(1)" class="block w-full" />
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-5">
                    <button type="button" class="btn2 w-full" onclick="window.location.href='/search'">Clear all filters</button>
                    <button type="submit" class="btn2 w-full btn-green">Search</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="mx-auto w-full max-w-7xl px-4 pt-5">
    <p id="sOptions" class="my-5"></p>
    <p id="specialtyOptions" class="mt-5"></p>
    <p id="typeOptions" class="mt-5"></p>
    <p id="careers" class="mt-5"></p>
    <p id="studentTypes" class="mt-5"></p>
</div>




@push('scripts')
    <script >
        let stateArr = [];
        let specialtyArr = [];
        let filterField = {state:[],location:[],type:[],specialty:[], start_after:[], end_before:[], price_range:[], career:[], studentType:[]}
        let typeArr = [];

        $(document).ready(function() {
            document.getElementById("type").addEventListener("click", function(event){
                event.preventDefault()
            });
            document.getElementById("state").addEventListener("click", function(event){
                event.preventDefault()
            });
            document.getElementById("speciality").addEventListener("click", function(event){
                event.preventDefault()
            });
            $('.filter-input').click(function(){
                if($(this).parent().find('.filter-list').attr('class').split(' ').pop()){
                    $(".filter-list").removeClass('show')
                    $(this).parent().find('.filter-list').addClass('show')
                    $('.clickOutSide').addClass('show')
                  }else{
                    $('.clickOutSide').removeClass('show')
                  }
            })
            $(document).on('click','.clickOutSide',function(){
                $(".filter-list").removeClass('show')
                $(this).removeClass('show')
            })
            $(".js-range-slider").ionRangeSlider({
                skin: "round",
                type: "double",
                grid: true,
                min: 0,
                max: {{ config('rotation.max_rotation_price') }},
                from: 0,
                to: {{ config('rotation.max_rotation_price') }},
                prefix: "$",
                prettify_separator:",",
                onFinish: function (data) {
                    changeInputs(data.from +';'+ data.to, 'price_range');
                },
            }
            );
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
                        filterField.career[0]= id
                        filterField.studentType[0]=$('#studentType').val()
                        $("#careers").html('<span class="px-3 py-1 text-sm font-semibold text-gray-700 mr-2 my-1 mb-2 w-32">Careers:</span>'+'<span class="bg-option rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 my-1 mb-2">' + $('#career option:selected').text() + '</span>');
                        $("#studentTypes").html('<span class="px-3 py-1 text-sm font-semibold text-gray-700 mr-2 my-1 mb-2 w-32">Student Type:</span>'+'<span class="bg-option rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 my-1 mb-2">' + $('#studentType option:selected').text() + '</span>');
                        filter(filterField)
                    },
                    error: function(result){
                        console.log(result);
                    }
                })
            })
            $('#studentType').change(function(){
                let id =$(this).val()
                filterField.studentType[0]=$(this).val()
                $("#studentTypes").html('<span class="px-3 py-1 text-sm font-semibold text-gray-700 mr-2 my-1 mb-2 w-32">Student Type:</span>'+'<span class="bg-option rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 my-1 mb-2">' + $('#studentType option:selected').text() + '</span>');
                filter(filterField)
            })
        });
        /* When the user clicks on the button,
toggle between hiding and showing the dropdown content */
function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}

function states() {
  document.getElementById("state-content").classList.toggle("show");
}

function specialities() {
  document.getElementById("speciality-div").classList.toggle("show");
}

function addOption(option) {
    if(option=='Any'){
        if(stateArr.includes(option)){
            stateArr.splice(stateArr.indexOf(option), 1);
            filterField.state.splice(filterField.state.indexOf(option), 1);
        }else{
            stateArr=['Any'];
            filterField.state = ['Any']
            $('#state-content .checkbox').each(function(index){
                if($(this).val()!=='Any'){
                    $(this).prop('checked',false)
                }
            })
        }
    }else{
        if(stateArr.includes(option)) {
            stateArr.splice(stateArr.indexOf(option), 1);
            filterField.state.splice(filterField.state.indexOf(option), 1);
        } else {
            stateArr.push(option);
            filterField.state.push(option)
        }
    }
    document.getElementById("sOptions").innerHTML = '<span class="px-3 py-1 text-sm font-semibold text-gray-700 mr-2 my-1 mb-2 w-32">States:</span>';
    stateArr.forEach(function(item, index) {
        document.getElementById("sOptions").innerHTML += '<span class="bg-option rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 my-1 mb-2">' + item + '</span>';
    });
    filter(filterField)

}

function addType(option) {
    if(option=='Any'){
        if(typeArr.includes(option)){
            typeArr.splice(typeArr.indexOf(option), 1);
            filterField.type.splice(filterField.type.indexOf(option), 1);
        }else{
            typeArr=['Any'];
            filterField.type = ['Any']
            $('#myDropdown .checkbox').each(function(index){
                if($(this).val()!=='any'){
                    $(this).prop('checked',false)
                }
            })
        }
    }else{
        if(typeArr.includes(option)) {
            typeArr.splice(typeArr.indexOf(option), 1);
            filterField.type.splice(filterField.type.indexOf(option),1)
        } else {
            typeArr.push(option);
            filterField.type.push(option)
        }
    }
    document.getElementById("typeOptions").innerHTML = '<span class="px-3 py-1 text-sm font-semibold text-gray-700 mr-2 my-1 mb-2 w-32">Types:</span>';
    typeArr.forEach(function(item, index) {
        document.getElementById("typeOptions").innerHTML += '<span class="bg-option rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 my-1 mb-2">' + item + '</span>';
    });
    filter(filterField)
}

function addSpecialty(option, key) {
    if(option=='Any'){
        if(specialtyArr.includes(option)){
            specialtyArr.splice(specialtyArr.indexOf(option), 1);
            filterField.specialty.splice(filterField.specialty.indexOf(key), 1);
        }else{
            specialtyArr=['Any'];
            filterField.specialty=['Any'];
            $('#speciality-div .checkbox').each(function(index){
                if($(this).val()!=='0'){
                    $(this).prop('checked',false)
                }
            })
        }
    }else{
        if(specialtyArr.includes(option)) {
            specialtyArr.splice(specialtyArr.indexOf(option), 1);
            filterField.specialty.splice(filterField.specialty.indexOf(key), 1);
        } else {
            specialtyArr.push(option);
            filterField.specialty.push(key)
        }
    }
    document.getElementById("specialtyOptions").innerHTML = '<span class="px-3 py-1 text-sm font-semibold text-gray-700 mr-2 my-1 mb-2 w-32">Specialties:</span>';
    specialtyArr.forEach(function(item, index) {
        document.getElementById("specialtyOptions").innerHTML += '<span class="bg-type rounded-full px-3 py-1 text-sm font-semibold text-white mr-2 my-1 mb-2">' + item + '</span>';
    });
    filter(filterField)
}
function changeInputs(val,type){
    filterField[type]=val
    filter(filterField)
}
function filter(data){
    data.isJson = true
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })
    $.ajax({
            url: "{{url('/search')}}",
            method: 'post',
            data:data,
            success: function(result){
                console.log(result)
                if(result.rotations){
                    $('.opp-box').remove()
                    if(result.rotations.data.length > 0){
                        result.rotations.data.forEach(function(item,index){
                            var specialitiesHtml='<ul class="flex flex-wrap">';
                            if(item.specialties.length > 0){
                                item.specialties.forEach(function(it){
                                    specialitiesHtml+= `<li>${it.name}</li>`
                                })
                            }
                            specialitiesHtml+='</ul>'
                            var html = `
                                <div class="opp-box">
                                    <a href="/view/${item.id}">
                                        <div class="box" style="background-image: url(${item.image})">
                                            <div class="content flex justify-end flex-col h-full p-2">
                                                <h4>${item.preceptor_name}, ${item.hospital_name}</h4>
                                                ${specialitiesHtml}
                                                {{--  <ul class="flex flex-wrap">
                                                    @foreach($rotation->specialties as $specialty)
                                                        <li>{{ $specialty->name }}</li>
                                                    @endforeach
                                                </ul>  --}}
                                            </div>
                                        </div>
                                        <div class="price">$${item.price}</div>
                                        <div class="location flex"><x-icons.location/> ${item.city}, ${item.state }</div>
                                    </a>
                                </div>`
                            $('.box-container').append(html)
                        })
                    }
                }
            },
            error: function(result){
                console.log(result);
            }
    })
}
    </script>
    <script src="{{ asset('js/app.js') }}"></script>
@endpush
