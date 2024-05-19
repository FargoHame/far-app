@props(['name','id','autocompleteRoute'])

<div>
    <label class="block font-bold" for="{{ $id }}">{{ $name }}</label>
    <div  wire:ignore.self
        x-on:click.away="dropdown = false"
        x-data="{
            dropdown: false,
            results: [],
            autocomplete(input) {
                this.dropdown = true;
                if(input) {
                    axios.get('{{route($autocompleteRoute)}}?query='+input).then(results => {
                        this.results = results.data
                    })
                } else { this.results = []; }
            }
        }" class="mt-2 md:mb-0 mb-4 w-full">
        <div class="relative">
            <input type="text" name="search_input"
                    x-on:input.debounce.stop="autocomplete($event.target.value); if ($refs.search_input.value=='') { $wire.set_filter('{{$id}}','');  }"
                    x-on:keydown.enter.prevent="$refs.search_input.value = results[0].text; $wire.set_filter('{{$id}}',results[0].id); dropdown = false"
                    x-ref="search_input"
                    class="w-full"
                    autocomplete="off"
            />
            <div wire:ignore>
                <template x-if="dropdown && results.length > 0">
                    <div class="absolute w-full z-50">
                        <div class="border rounded-md bg-white shadow-xs">
                            <div class="py-1">
                                <template x-for="result in results">
                                    <div x-on:click="$refs.search_input.value = result.text; $wire.set_filter('{{$id}}',result.id); dropdown = false" class="block p-4 border-b border-gray-100 hover:bg-cream cursor-pointer">
                                        <p>
                                            <span x-text="result.text" class="font-medium mb-2"></span>
                                        </p>
                                        <p x-text="result.topic"></p>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

</div>