<x-app-layout>
    <!-- Metadata -->
    @section ('title', 'Find a Rotation')
    @section ('description', 'Careers')

    <div>
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg" style="background-color: rgb(255, 255, 255, 0.05);">
                <div class="p-6">
                    <div class="w-full">
                        <div class="custom-table">
                            @error('name')
                                <div class="text-red-600">Name field can not be empty.</div>
                            @enderror
                            @if (isset($_GET['success']))
                                @if( $_GET['success'] )
                                    <p class="bg-green-600 text-white p-4 mb-4">{{ $_GET['desc'] }}</p>
                                @else
                                    <p class="bg-red-500 text-white p-4 mb-4">{{ $_GET['desc'] }}</p>
                                @endif
                            @endif
                            <form method="post" action="{{ route('admin-add-career') }}">
                                @csrf   
                                <h2 class="font-bold text-xl">Add New Career</h2>                     
                                <div class="mt-4">
                                  <x-label for="name" :value="__('Name')" />
                                  <x-input id="name" name="name" class="block mt-1 w-full" required />
                                </div>                        
                                <div class="mt-3 pt-3 text-right">
                                  <x-button>Save changes</x-button>
                                </div>
                            </form>
                            <h2 class="font-bold text-xl">Career List</h2>
                            @if ($careers->count() == 0)
                            <div class="flex items-center justify-center pt-3">
                                <h2 class="text-white text-lg">No Careers available.</h2>
                            </div>
                            @endif
                            @foreach ( $careers as $career)
                            <form method="post" action="{{route('admin-update-career')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="grid grid-cols-1 mb-5">
                                    <div class="body grid grid-cols-2 items-center pt-5 pb-5 xl:border-b border-gray-500">
                                        <div>
                                            <label>Name</label>
                                            <input value="{{$career->name}}" class="text-center w-full h-10 rounded border mr-5" name="name" placeholder="Add Name" />
                                        </div>
                                        <div class="col-span-1 xl:h-16 flex justify-start items-center ml-5 pt-4">
                                            <button type="submit" class="bg-far-green-light font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-20 text-sm mr-5">Update
                                            </button>
                                            <input type="hidden" value="{{$career->id}}" name="id" />
                                            <a href="/admin/remove-career/{{$career->id}}" class="font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-20 text-sm bg-red-400 text-white">Delete
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            @endforeach
                        </div>
                        <div class="mt-6">
                            <div class="flex justify-center">
                                <div class="text-sm w-full" style="padding: 10px; border-radius: 10px">
                                    {{ $careers->links() }}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </x-app-layout>
  