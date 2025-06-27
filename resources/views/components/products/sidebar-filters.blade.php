{{-- resources/views/components/products/sidebar-filters.blade.php --}}
@props([
    'availableSizes' => collect(),
    'availablePriceRange' => ['min' => 0, 'max' => 0],
    'availableBrands' => collect(),
])

<aside class="w-1/4 p-4 text-white min-h-screen hide-under-810">

    <div class="w-auto max-w-80 p-4 border border-gray-200 rounded-lg">
        <!-- Filters Header -->
        <h2 class="text-xl font-medium text-secondary-800 mb-4">Filters</h2>

        <!-- Availability Section -->
        <div class="mb-6" x-data="{
            inStock: {{ request()->get('in_stock') ? 'true' : 'false' }},
            outOfStock: {{ request()->get('out_of_stock') ? 'true' : 'false' }},
            isOpen: true,
            updateFilters() {
                const params = new URLSearchParams(window.location.search);

                if (this.inStock) {
                    params.set('in_stock', '1');
                } else {
                    params.delete('in_stock');
                }

                if (this.outOfStock) {
                    params.set('out_of_stock', '1');
                } else {
                    params.delete('out_of_stock');
                }

                window.location.href = window.location.origin + window.location.pathname + '?' + params.toString();
            }
        }">
            <button @click="isOpen = !isOpen" class="flex items-center justify-between w-full text-left text-secondary-800 font-medium mb-3">
                Par stock
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200" :class="{'rotate-180': !isOpen}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                </svg>
            </button>

            <div class="space-y-2" x-show="isOpen"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                 x-transition:enter-end="opacity-100 transform translate-y-0">
                <label class="flex items-center">
                    <input type="checkbox" id="inStock" class="form-checkbox h-4 w-4 text-secondary-800"
                           x-model="inStock" @change="updateFilters()">
                    <span class="ml-2 text-gray-600">Disponible</span>
                </label>
                <label class="flex items-center">
                    <input type="checkbox" id="outStock" class="form-checkbox h-4 w-4 text-secondary-800"
                           x-model="outOfStock" @change="updateFilters()">
                    <span class="ml-2 text-gray-600">En rupture</span>
                </label>
            </div>
        </div>

        <!-- Price Section -->
        <div class="bg-white rounded-lg mb-4" x-data="{ open: true }">
            <button @click="open = !open" class="flex items-center justify-between w-full text-left text-secondary-800 font-medium mb-3">
                Par Prix
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200" :class="{'rotate-180': !open}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                </svg>
            </button>

            <div x-show="open"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                 x-transition:enter-end="opacity-100 transform translate-y-0">

                <form method="GET" id="price-filter-form">
                    @foreach(request()->except(['min_price', 'max_price', 'page']) as $key => $value)
                        @if(is_array($value))
                            @foreach($value as $arrValue)
                                <input type="hidden" name="{{ $key }}[]" value="{{ $arrValue }}">
                            @endforeach
                        @else
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endif
                    @endforeach

                    <input type="hidden" name="min_price" id="min_price" value="{{ request('min_price', $availablePriceRange['min']) }}">
                    <input type="hidden" name="max_price" id="max_price" value="{{ request('max_price', $availablePriceRange['max']) }}">

                    <div class="flex justify-between mb-2">
                        <div class="bg-primary-700 text-white font-medium px-3 py-1 rounded text-sm">
                            €<span id="display-min-price">{{ $availablePriceRange['min'] }}</span>
                        </div>
                        <div class="bg-primary-700 text-white font-medium px-3 py-1 rounded text-sm">
                            €<span id="display-max-price">{{ $availablePriceRange['max'] }}</span>
                        </div>
                    </div>

                    <!-- Slider would go here if you want to add JS later -->
                        <!-- Price slider track (for draggable thumbs) -->
                        <div class="relative h-1 my-6" id="slider-track">
                            <div class="absolute w-full h-1 bg-gray-200 rounded"></div>
                            <div id="active-track" class="absolute h-1 bg-primary-700 rounded"></div>
                            <div id="min-thumb" class="absolute w-5 h-5 bg-primary-700 rounded-full -top-2 -ml-2.5 shadow cursor-pointer z-20"></div>
                            <div id="max-thumb" class="absolute w-5 h-5 bg-primary-700 rounded-full -top-2 -ml-2.5 shadow cursor-pointer z-20"></div>
                        </div>

                    <div class="grid grid-cols-2 gap-2 mt-4">
                        <div class="flex">
                            <div class="flex items-center justify-center bg-gray-100 px-2 border border-r-0 rounded-l">
                                <span class="text-gray-600">€</span>
                            </div>
                            <input
                                type="number"
                                id="min_price_input"
                                value="{{ request('min_price', $availablePriceRange['min']) }}"
                                min="{{ $availablePriceRange['min'] }}"
                                max="{{ $availablePriceRange['max'] }}"
                                class="w-full border py-1 px-2 text-gray-700 rounded-r text-sm focus:outline-none focus:ring-1 focus:ring-[#2E3F85]"
                            />
                        </div>

                        <div class="flex">
                            <div class="flex items-center justify-center bg-gray-100 px-2 border border-r-0 rounded-l">
                                <span class="text-gray-600">€</span>
                            </div>
                            <input
                                type="number"
                                id="max_price_input"
                                value="{{ request('max_price', $availablePriceRange['max']) }}"
                                min="{{ $availablePriceRange['min'] }}"
                                max="{{ $availablePriceRange['max'] }}"
                                class="w-full border py-1 px-2 text-gray-700 rounded-r text-sm focus:outline-none focus:ring-2 focus:ring-[#2E3F85]"
                            />
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Size Section -->
        <div class="mb-6" x-data="{
            selectedSizes: {{ json_encode(
                request()->filled('sizes')
                    ? (is_array(request()->get('sizes')) ? request()->get('sizes') : explode(',', request()->get('sizes')))
                    : []
            ) }},
            isOpen: true,
            updateFilters() {
                const params = new URLSearchParams(window.location.search);

                // Preserve stock filters (if already in URL)
                if (this.inStock !== undefined) {
                    if (this.inStock) {
                        params.set('in_stock', '1');
                    } else {
                        params.delete('in_stock');
                    }
                }

                if (this.outOfStock !== undefined) {
                    if (this.outOfStock) {
                        params.set('out_of_stock', '1');
                    } else {
                        params.delete('out_of_stock');
                    }
                }

                // Preserve size filters
                if (this.selectedSizes.length > 0) {
                    params.set('sizes', this.selectedSizes.join(','));
                } else {
                    params.delete('sizes');
                }

                // Preserve price filters
                const minPriceInput = document.getElementById('min_price_input');
                const maxPriceInput = document.getElementById('max_price_input');
                if (minPriceInput && maxPriceInput) {
                    params.set('min_price', minPriceInput.value);
                    params.set('max_price', maxPriceInput.value);
                }

                window.location.href = window.location.origin + window.location.pathname + '?' + params.toString();
            }
        }">
            <button @click="isOpen = !isOpen" class="flex items-center justify-between w-full text-left text-secondary-800 font-medium mb-3">
                Taille
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200" :class="{'rotate-180': !isOpen}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                </svg>
            </button>

            <div class="space-y-2" x-show="isOpen"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                 x-transition:enter-end="opacity-100 transform translate-y-0">

                @foreach($availableSizes as $size)
                    <label class="flex items-center">
                        <input
                            type="checkbox"
                            value="{{ (string) $size->id }}"
                            class="form-checkbox h-4 w-4 text-secondary-800"
                            x-model="selectedSizes"
                            @change="updateFilters()"
                        >
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
    isOpen: true,
    updateFilters() {
        const params = new URLSearchParams(window.location.search);

        // Preserve stock filters
        if (this.inStock !== undefined) {
            if (this.inStock) {
                params.set('in_stock', '1');
            } else {
                params.delete('in_stock');
            }
        }

        if (this.outOfStock !== undefined) {
            if (this.outOfStock) {
                params.set('out_of_stock', '1');
            } else {
                params.delete('out_of_stock');
            }
        }

        // Preserve selected sizes
        if (this.selectedSizes && this.selectedSizes.length > 0) {
            params.set('sizes', this.selectedSizes.join(','));
        } else {
            params.delete('sizes');
        }

        // Preserve selected brands
        if (this.selectedBrands && this.selectedBrands.length > 0) {
            params.set('brands', this.selectedBrands.join(','));
        } else {
            params.delete('brands');
        }

        // Preserve price
        const minPriceInput = document.getElementById('min_price_input');
        const maxPriceInput = document.getElementById('max_price_input');
        if (minPriceInput && maxPriceInput) {
            params.set('min_price', minPriceInput.value);
            params.set('max_price', maxPriceInput.value);
        }

        window.location.href = window.location.origin + window.location.pathname + '?' + params.toString();
    }
}">
            <button @click="isOpen = !isOpen" class="flex items-center justify-between w-full text-left text-secondary-800 font-medium mb-3">
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
                        <input
                            type="checkbox"
                            value="{{ (string) $brand->id }}"
                            class="form-checkbox h-4 w-4 text-secondary-800"
                            x-model="selectedBrands"
                            @change="updateFilters()"
                        >
                        <span class="ml-2 text-gray-600">{{ $brand->name }}
                        @if($brand->products_count > 0)
                            ({{ $brand->products_count }})
                        @endif
                        </span>
                    </label>
                @endforeach

            </div>
        </div>

    </div>
</aside>
<script>

</script>
