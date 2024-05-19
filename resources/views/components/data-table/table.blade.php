@props(['title','itemType','pagination' => null,'sortOptions','filterOptions', 'minWidth','search' => false, 'class' => 'w-full'])

<div class="mx-auto {{ $class }} px-4 pt-5 md:mt-6 mb-4" x-data="{ filter_open: false }">
    <div class="pb-4 mb-4 border-b border-gray-600 border-dashed">
            @isset($titleButtons)
            <div class="md:hidden mb-4 -mt-10 flex justify-end">
            {{ $titleButtons }}
            </div>
            @endisset

        <div class="md:flex items-center">
            <h1 class="text-3xl font-bold">{{ $title }}</h1>
            @isset($sortOptions)
            <x-data-table.sort-select :options="$sortOptions" />
            @endisset
            @isset($filterOptions)
            <div class="flex items-center md:ml-4 md:mt-0 mt-3 cursor-pointer" x-show="!filter_open" @click="filter_open=true">
                <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                <div class="ml-1">
                  Filter results
                </div>
            </div>
            <div class="flex items-center md:ml-4 md:mt-0 mt-3" x-cloak x-show="filter_open">
                <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="#FDC5A7">
                    <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                </svg>
                <div class="font-bold">
                  Filtering results
                </div>
            </div>
            @endisset
            @isset($titleButtons)
            <div class="md:flex md:flex-1 justify-end hidden">
            {{ $titleButtons }}
            </div>
            @endisset
            @if($search)
            <input type="text" value="" placeholder="Search" class="md:ml-auto md:mr-4 md:mt-0 mt-3" wire:model="search_query"/>
            @endif
        </div>
        @isset($filterOptions)
        <div class="mt-4 px-5 pt-1 pb-5 bg-far-orange-light" x-cloak x-show="filter_open">
            <div class="md:grid xl:grid-cols-4 md:grid-cols-3 gap-12 mt-3">
                @foreach ($filterOptions as $id => $filter)
                    @if (($filter['type'] ?? 'select')=='autocomplete')
                        <x-data-table.filter-autocomplete :name="$filter['name']" :id="$id" :autocomplete_route="$filter['route']" />
                    @elseif (($filter['type'] ?? 'select')=='text')
                        <x-data-table.filter-text :name="$filter['name']" :id="$id"/>
                    @else
                        <x-data-table.filter-select :name="$filter['name']" :id="$id" :options="$filter['options']" />
                    @endif
                @endforeach
            </div>
        </div>
        @endisset
    </div>

    <div class="relative" x-data="{total:0}" @selection-updated="$event.detail.value?total++:((total>0)?total--:total=0)" x-init="$wire.on('selection-reset', () => {total=0;})">
        @isset($actions)
        <div class="h-12 pl-4 bg-black bg-opacity-100 text-white absolute w-full flex items-center" x-show="total>0" x-cloak>
            <div>
                <span x-text="total"></span> {{ $itemType }}<span x-show="total>1">s</span> selected:
            </div>
            {{ $actions }}
        </div>
        @endisset
        <div class="overflow-x-auto">
            <table class="w-full @isset($minWidth) min-w-{{ $minWidth }} @endisset">
                @isset($header)
                <tr class="bg-cream font-semibold">
                    @isset($actions)
                    <td class="h-12"></td>
                    @endisset
                    {{ $header ?? '' }}
                </tr>
                @endisset
                {{ $slot }}
            </table>
        </div>

        @isset($pagination)
        <div class="mt-4">
            {{ $pagination->links() }}
        </div>
        @endisset

        <div wire:loading>
            <div class="absolute w-full h-full bg-cream top-0 right-0 opacity-50 flex items-center">
                <div class="mx-auto preloader h-16 w-16"><span></span><span></span></div>
            </div>
        </div>
    </div>
</div>