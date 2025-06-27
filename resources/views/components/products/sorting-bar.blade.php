@props([
    'availableSizes' => collect(),
    'availablePriceRange' => ['min' => 0, 'max' => 0],
    'availableBrands' => collect(), // 👈 ADD THIS
])

<div class="mb-6 flex justify-between items-center gap-5" x-data="{
    selectedSort: '{{ request()->get('sort', '-updated_at') }}',
    updateUrl() {
        const params = new URLSearchParams(window.location.search);
        if (this.selectedSort && this.selectedSort !== '-updated_at') {
            params.set('sort', this.selectedSort);
        } else {
            params.delete('sort');
        }
        window.location.href = window.location.origin + window.location.pathname + '?' + params.toString();
    }
}">

    <div class="relative w-full md:hidden max-w-sm mx-auto z-20" x-data="{ open: false }">
        <!-- Filter Button -->
        <button
            @click="open = !open"
            class="flex items-center justify-between px-4 py-3 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#2E3F85] focus:border-[#2E3F85]">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-secondary-800 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h18M4 8h16M4 12h16m-7 4h7" />
                </svg>
                <span class="font-medium text-secondary-800">Filters</span>
            </div>
        </button>

        <!-- Dropdown Panel -->
        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-1"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-1"
            x-cloak
            class="absolute transform w-[85vw] z-10 mt-2 bg-white border border-gray-200 rounded-lg shadow-lg flex flex-col"
            style="max-height: calc(85vh - 120px);"
        >
            <!-- Main scrollable content area -->
            <div class="overflow-y-auto flex-1">
                <div class="p-4">
                    <h2 class="text-xl font-bold text-secondary-800 mb-4">Filters</h2>

                    <form id="mobile-filter-form" method="GET">
                        @foreach(request()->except(['min_price', 'max_price', 'in_stock', 'out_of_stock', 'sizes', 'page']) as $key => $value)
                            @if(is_array($value))
                                @foreach($value as $arrValue)
                                    <input type="hidden" name="{{ $key }}[]" value="{{ $arrValue }}">
                                @endforeach
                            @else
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endif
                        @endforeach

                        <!-- Availability Section -->
                        <div class="mb-6" x-data="{
                            inStock: {{ request()->get('in_stock') ? 'true' : 'false' }},
                            outOfStock: {{ request()->get('out_of_stock') ? 'true' : 'false' }},
                            isOpen: true
                        }">
                            <button type="button" @click="isOpen = !isOpen"
                                    class="flex items-center justify-between w-full text-left text-secondary-800 font-medium mb-3">
                                Par stock
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200"
                                     :class="{'rotate-180': !isOpen}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                </svg>
                            </button>

                            <div class="space-y-2" x-show="isOpen"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                                 x-transition:enter-end="opacity-100 transform translate-y-0">
                                <label class="flex items-center">
                                    <input type="checkbox" name="in_stock" value="1" class="form-checkbox h-4 w-4 text-secondary-800" {{ request('in_stock') ? 'checked' : '' }}>
                                    <span class="ml-2 text-gray-600">Disponible</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="out_of_stock" value="1" class="form-checkbox h-4 w-4 text-secondary-800" {{ request('out_of_stock') ? 'checked' : '' }}>
                                    <span class="ml-2 text-gray-600">En rupture</span>
                                </label>
                            </div>
                        </div>

                        <!-- Price Section -->
                        <div class="mb-6" x-data="{ open: true }">
                            <button type="button" @click="open = !open"
                                    class="flex items-center justify-between w-full text-left text-secondary-800 font-medium mb-3">
                                Par Prix
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200"
                                     :class="{'rotate-180': !open}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                </svg>
                            </button>

                            <div x-show="open"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                                 x-transition:enter-end="opacity-100 transform translate-y-0">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="relative">
                                        <label for="min_price" class="block text-sm font-medium text-gray-900 mb-1">Min</label>
                                        <div class="relative rounded-md shadow-sm">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500">€</span>
                                            </div>
                                            <input type="number" name="min_price" id="min_price"
                                                   value="{{ request('min_price', $availablePriceRange['min']) }}"
                                                   min="{{ $availablePriceRange['min'] }}" max="{{ $availablePriceRange['max'] }}"
                                                   class="block w-full pl-7 pr-2 py-2 border border-gray-500 rounded-md focus:ring-secondary-800 focus:border-secondary-800">
                                        </div>
                                    </div>

                                    <div class="relative">
                                        <label for="max_price" class="block text-sm font-medium text-gray-900 mb-1">Max</label>
                                        <div class="relative rounded-md shadow-sm">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500">€</span>
                                            </div>
                                            <input type="number" name="max_price" id="max_price"
                                                   value="{{ request('max_price', $availablePriceRange['max']) }}"
                                                   min="{{ $availablePriceRange['min'] }}" max="{{ $availablePriceRange['max'] }}"
                                                   class="block w-full pl-7 pr-2 py-2 border border-gray-500 rounded-md focus:ring-secondary-800 focus:border-secondary-800">
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-2 text-sm text-gray-500 text-right">
                                    Range: €{{ $availablePriceRange['min'] }} - €{{ $availablePriceRange['max'] }}
                                </p>
                            </div>
                        </div>

                        <!-- Size Section -->
                            <!-- Size Section -->
                            <div class="mb-6" x-data="{
                                selectedSizes: {{ json_encode(
                                    request()->filled('sizes')
                                        ? (is_array(request()->get('sizes')) ? request()->get('sizes') : explode(',', request()->get('sizes')))
                                        : []
                                ) }},
                                    isOpen: true
                                }">
                                <button type="button" @click="isOpen = !isOpen"
                                        class="flex items-center justify-between w-full text-left text-secondary-800 font-medium mb-3">
                                    Taille
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200"
                                         :class="{'rotate-180': !isOpen}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                    </svg>
                                </button>

                                <div class="space-y-2" x-show="isOpen"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 transform -translate-y-2"
                                     x-transition:enter-end="opacity-100 transform translate-y-0">
                                    @foreach($availableSizes as $size)
                                        <label class="flex items-center">
                                            <input type="checkbox" name="sizes[]" value="{{ $size->id }}"
                                                   class="form-checkbox h-4 w-4 text-secondary-800"
                                                {{ in_array(
                                                    $size->id,
                                                    is_array(request('sizes')) ? request('sizes') : explode(',', request('sizes', ''))
                                                ) ? 'checked' : '' }}>
                                            <span class="ml-2 text-gray-600">
                                                {{ $size->name }}
                                                @if($size->products_count > 0)
                                                    ({{ $size->products_count }})
                                                @endif
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>


                            <!-- Brand Section -->
                            <div class="mb-6" x-data="{
    selectedBrands: {{ json_encode(request()->filled('brands') ? explode(',', request()->get('brands')) : []) }},
    isOpen: true
}">
                                <button type="button" @click="isOpen = !isOpen"
                                        class="flex items-center justify-between w-full text-left text-secondary-800 font-medium mb-3">
                                    Marque
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200"
                                         :class="{'rotate-180': !isOpen}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                    </svg>
                                </button>

                                <div class="space-y-2" x-show="isOpen"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 transform -translate-y-2"
                                     x-transition:enter-end="opacity-100 transform translate-y-0">

                                    @foreach($availableBrands as $brand)
                                        <label class="flex items-center">
                                            <input type="checkbox"
                                                   name="brands[]"
                                                   value="{{ $brand->id }}"
                                                   class="form-checkbox h-4 w-4 text-secondary-800"
                                                   x-model="selectedBrands"
                                                {{ in_array((string)$brand->id, request()->filled('brands') ? explode(',', request()->get('brands')) : []) ? 'checked' : '' }}>
                                            <span class="ml-2 text-gray-600">
                    {{ $brand->name }}
                                                @if($brand->products_count ?? 0 > 0)
                                                    ({{ $brand->products_count }})
                                                @endif
                </span>
                                        </label>
                                    @endforeach

                                    <!-- Hidden input to submit brands as comma separated -->
                                    <input type="hidden" name="brands" :value="selectedBrands.join(',')">
                                </div>
                            </div>

                    </form>
                </div>
            </div>

            <!-- Sticky Footer -->
            <div class="sticky bottom-0 bg-white border-t border-gray-200 p-3 flex space-x-3 shadow-md">
                <button type="button" onclick="window.location.href = window.location.pathname;"
                        class="flex-1 px-4 py-2.5 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Reset
                </button>
                <button type="submit" form="mobile-filter-form"
                        class="flex-1 px-4 py-2.5 bg-primary-500 text-white rounded-md text-sm font-medium hover:bg-secondary-700">
                    Apply
                </button>
            </div>
        </div>
    </div>

    <div class="flex items-center justify-end">
        <label class="text-slate-700 mr-2">Sort by:</label>
        <x-input
            x-model="selectedSort"
            @change="updateUrl"
            type="select"
            name="sort"
            class="w-48 focus:border-slate-600 focus:ring-slate-600 border-gray-300 rounded-md shadow-sm text-sm">
            <option value="price">Price (ASC)</option>
            <option value="-price">Price (DESC)</option>
            <option value="title">Title (ASC)</option>
            <option value="-title">Title (DESC)</option>
            <option value="-updated_at">Last Modified (Top)</option>
            <option value="updated_at">Last Modified (Bottom)</option>
        </x-input>
    </div>
</div>
