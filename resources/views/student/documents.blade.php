<x-app-layout>
    @section ('title', "View documents")

    <div class=" input-hidden mb-5" x-data="{open:false, application:0}">
        <div class="mx-auto w-full max-w-7xl px-4 pt-5">
            <div class="pb-4 mb-4">
                <div class="md:flex items-center">
                    <h1 class="text-3xl font-bold">My Documents</h1>
                </div>


            <div style="justify-content: left;" class="pb-8 pt-8 md:grid grid-col-12 grid-flow-col">
                <div class="grid-col-10">
                    <div class="md:flex items-center">
                        <svg style=" transform: rotate(180deg);" xmlns="http://www.w3.org/2000/svg" width="32" height="32" version="1.1" viewBox="0 0 32 32" class="hidden lg:block">
                            <g transform="translate(-2,2)">
                                <circle style="fill:#252a35" cx="18" cy="14" r="14"/>
                                <circle style="fill:#ffffff" cx="17.5" cy="22.5" r="1.5"/>
                                <path style="fill:#ffffff;fill-rule:evenodd" d="m 16,19 3,0 0,-14 -3,0 z"/>
                            </g>
                        </svg>
                        <h5 class="customcolor text-x flex items-center ml-2">
                            These documents are required by most preceptors. if preceptors require additional documents, the will be added to this list and you can reuse them for other institutions.</h5>
                    </div>
                </div>
            </div>
                <form method="POST" action="{{ route('documents-save') }}" enctype='multipart/form-data' novalidate>
                    @csrf
                   <div class="ovflow">
                @if (count($documents) > 0)
                    @foreach($documents as $document)
                        <div  class="pt-8 document-{{$document->id}} documents mb-4 lg:block">
                            <div class="md:grid grid-cols-3 grid-flow-col gap-5 body">
                                <div class="flex flex-row col-span-1">
                                    <span class="text-gray-500 mr-3"><x-icons.document/></span>
                                    <div class="flex flex-col">
                                        <a title="download" href="{{ $document->path }}"> <b id="name_{{ $document->type->id }}" class="titlefield">{{$document->filename}}</b></a>
                                        <span class="text-gray-500 text-xs">Document: {{$document->type->name}}</span>
                                    </div>
                                </div>
                                <div class="flex flex-row col-span-1">
                                    <div class="flex flex-col col-span-2 items-center">
                                        <span class="text-gray-500">Upladed: {{ Carbon\Carbon::parse($document->created_at)->toFormattedDateString() }}</span>
                                    </div>
                                </div>
                                <div class="flex flex-row col-span-1 justify-end align-top">
                                    <label class="text-far-green-dark flex cursor-pointer items-center">
                                        <input data-id="{{ $document->type->id }}" name="file" type="file"  id="fileid{{ $document->type->id }}" class="hidden updatefile">
                                        <x-icons.upload/>
                                        <b class="ml-2">Upload the latest version<br/><span class="name"></span></b>
                                    </label>
                                    <label class="text-red-600 flex ml-5 cursor-pointer items-center" for="id-{{$document->id}}">
                                        <x-icons.trash/>
                                        <input type="submit" name="delete" value="{{$document->id}}" id="id-{{$document->id}}" class="text-red-600 flex ml-5 cursor-pointer hidden">
                                        <b class="ml-2">Delete</b>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Mobile view -->
                    {{--  <div class="lg:hidden rotations mb-4">
                        @foreach($documents as $document)
                            <div class="py-2 cursor-pointer body" x-data="{ open: false }">
                                <div class="flex justify-between items-center" @click="open = !open">
                                    <div class="mt-2">
                                        <a title="download" href="{{ $document->path }}"><b id="name_{{ $document->type->id }}" class="text-xs titlefield">{{$document->filename}}</b> </a>
                                    </div>
                                    <div x-show="!open">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                    <div x-show="open">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
                                        </svg>
                                    </div>
                                </div>
                                <div x-show="open">
                                    <div class="mt-2">
                                        <span class="text-gray-500 ">Document: {{$document->type->name}}</span>
                                    </div>
                                    <div class="mt-2">
                                        <span class="text-gray-500">Upladed: {{ Carbon\Carbon::parse($document->created_at)->toFormattedDateString() }}</span>
                                    </div>
                                    <div class="mt-2">
                                        <label class="text-far-green-dark flex mb-3">
                                            <x-icons.upload/>
                                            <b class="ml-5">Upload the latest version</b>
                                            <span class="name ml-2"></span>
                                            <input name="file" type="file" data-id="{{ $document->type->id }}" id="fileid{{ $document->type->id }}" class="hidden updatefileMobile">
                                        </label>
                                    </div>
                                    <div class="mt-2">
                                        <label class="text-red-600 flex cursor-pointer items-center" for="id-{{$document->id}}">
                                            <x-icons.trash/>
                                            <input type="submit" name="delete" value="{{$document->id}}" id="id-{{$document->id}}" class="text-red-600 flex ml-5 cursor-pointer hidden">
                                            <b class="ml-2">Delete</b>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>  --}}
                @endif

                @if (count($filesType) > 0)
                    @foreach($filesType as $fileType)
                        <div  class="pt-8 documents mb-4 lg:block">
                            <div class="md:grid grid-cols-3 grid-flow-col gap-5 body">
                                <div class="flex flex-row col-span-1">
                                    <span class="text-gray-500 opacity-50 mr-3"><x-icons.document/></span>
                                    <div class="flex flex-col">
                                        <b class="text-gray-500 titlefield">Not Subtmitted</b>
                                        <span class="text-gray-500 text-sm">Document: {{$fileType->name}}</span>
                                    </div>
                                </div>
                                <div class="flex flex-row col-span-1">
                                    <div class="flex flex-col col-span-2 items-center">
                                        <span class="text-gray-500">Upladed: {{ Carbon\Carbon::now()->toFormattedDateString() }}</span>
                                    </div>
                                </div>
                                <div class="flex flex-row col-span-1 justify-end align-top">
                                    <label class="text-far-green-dark flex flex-col cursor-pointer">
                                        <x-icons.upload-icon/>
                                        <span class="name"></span>
                                        <input data-id="{{ $fileType->id }}" name="fileid{{ $fileType->id }}" type="file"  id="fileid{{ $fileType->id }}" class="updatefile hidden">
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{--  <!-- Mobile view -->
                    <div class="lg:hidden rotations mb-4">
                            @foreach($filesType as $fileType)
                                <div class="py-2 cursor-pointer body" x-data="{ open: false }">
                                    <div class="flex justify-between items-center" @click="open = !open">
                                        <b class="text-gray-500 titlefield">Not Subtmitted</b>
                                        <div x-show="!open"> 
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                        <div x-show="open">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div x-show="open">
                                        <div class="mt-2">
                                            <span class="text-gray-500">Document: {{$fileType->name}}</span>
                                        </div>
                                        <div class="mt-2">
                                            <span class="text-gray-500">Upladed: {{ Carbon\Carbon::now()->toFormattedDateString() }}</span>
                                        </div>
                                        <div class="mt-2">
                                            <label class="text-far-green-dark flex mb-3">
                                                <x-icons.cloud/>
                                                <b class="ml-5">Upload</b>
                                                <span class="name ml-2"></span>
                                                <input data-id="{{ $fileType->id }}" name="file" type="file" id="fileid{{ $fileType->id }}" class="hidden updatefileMobile">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                     </div>  --}}
                @endif

            </div>
                    <div class="mt-12 px-2 message-container">
                            <div class="mt-4 flex items-center justify-end">
                                <button type="submit"  class="btn2 btn-green ml-5">Save</button>
                            </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('js/documents.js') }}"></script>
    @endpush

</x-app-layout>
