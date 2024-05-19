@props(['name','id','autocompleteRoute','value' => ''])

<div>
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
        }" class="mt-1 w-full">
        <div class="relative">
            <div class="select-field">
                <input type="text" name="{{ $id }}"
                    x-on:input.debounce.stop="autocomplete($event.target.value);"
                    x-on:keydown.enter.prevent="if (results[0]) $refs.search_input.value = results[0]; dropdown = false"
                    x-ref="search_input"
                    class="border rounded-sm border-gray-300 h-12 ring-0 focus:ring-0 focus:outline-none focus:border-far-green-dark px-2 w-full"
                    autocomplete="off"
                    value="{{ $value }}"
                />
            </div>
            <div wire:ignore>
                <template x-if="dropdown && results.length > 0">
                    <div class="absolute w-full z-50 overflow-scroll" style="height:300px">
                        <div class="border rounded-md bg-white shadow-xs">
                            <div class="py-1">
                                <template x-for="result in results">
                                    <div x-on:click="$refs.search_input.value = result; dropdown = false" class="block p-4 border-b border-gray-100 hover:bg-cream cursor-pointer">
                                        <p>
                                            <span x-text="result" class="font-medium mb-2"></span>
                                        </p>
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