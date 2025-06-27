


<div x-data="{ viewMode: 'grid' }">
    <div class="mb-6 flex justify-between items-center">
        <div class="text-lg font-semibold text-gray-700">
            {{ $products->total() }} Products
        </div>
        <div class="flex items-center space-x-4">
            <span class="text-sm text-gray-500">View:</span>
            <button @click="viewMode = 'grid'" :class="{ 'text-blue-600': viewMode === 'grid', 'text-gray-400 hover:text-gray-600': viewMode !== 'grid' }" class="focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
            </button>
            <button @click="viewMode = 'list'" :class="{ 'text-blue-600': viewMode === 'list', 'text-gray-400 hover:text-gray-600': viewMode !== 'list' }" class="focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Grid View -->
    <div x-show="viewMode === 'grid'" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6">
        @foreach ($products as $product)
            <x-landing.product-card-preview :product="$product" />
        @endforeach
    </div>
    <!-- List View -->


    <div x-show="viewMode === 'list'" class="flex flex-col divide-y divide-gray-200">
        @foreach($products as $product)
            @php
                $hasSizes = isset($product->sizes) && count($product->sizes) > 0;
                $prices = $hasSizes ? collect($product->sizes)->pluck('pivot.price')->map(fn($p) => floatval($p))->toArray() : [];
                $minPrice = $prices ? min($prices) : $product->price;
                $maxPrice = $prices ? max($prices) : $product->price;
                $hasDiscount = $product->original_price && $product->original_price > $product->price;
                $discount = $hasDiscount ? round((($product->original_price - $product->price) / $product->original_price) * 100) : null;
                // Calculate original price info for each size if available
                $originalPrices = $hasSizes
                    ? collect($product->sizes)->pluck('pivot.original_price')->filter()->map(fn($p) => floatval($p))->toArray()
                    : [];
                $minOriginalPrice = $originalPrices ? min($originalPrices) : null;
                $maxOriginalPrice = $originalPrices ? max($originalPrices) : null;
            @endphp

            <div
                class="flex flex-col md:flex-row overflow-hidden py-4 transition-all hover:bg-gray-50"
                x-data="productItem({{ json_encode([
                'id' => $product->id,
                'slug' => $product->slug,
                'image' => $product->image ?: '/img/noimage.png',
                'title' => $product->title,
                'price' => $product->price,
                'originalPrice' => $product->original_price ?? null,
                'addToCartUrl' => route('cart.add', $product),
                'sizes' => $hasSizes ? collect($product->sizes)->map(fn($size) => [
                    'id'    => $size->id,
                    'name'  => $size->name,
                    'price' => $size->pivot->price,
                    'originalPrice' => $size->pivot->original_price ?? null,
                    'stock' => $size->pivot->stock,
                ]) : [],
                'minOriginalPrice' => $minOriginalPrice,
                'maxOriginalPrice' => $maxOriginalPrice
            ]) }})"
            >
                {{-- Image and Discount --}}
                <a class="relative w-full md:w-1/5 lg:w-1/6 flex-shrink-0 overflow-hidden" href="{{ route('products.view', $product->slug) }}">
                    <div class="w-full h-40 sm:h-44 md:h-36 bg-white flex items-center justify-center p-2 sm:p-4">
                        <img class="object-contain w-full h-full transition-transform duration-300 hover:scale-105"
                             :src="product.image"
                             alt="{{ $product->title }}" />
                    </div>

                    @if($discount)
                        <div class="absolute top-2 left-2 bg-secondary text-white text-xs font-bold px-2 py-1 rounded-md z-10">
                            -{{ $discount }}%
                        </div>
                    @endif
                </a>

                {{-- Product Info --}}
                <div class="w-full md:w-4/5 lg:w-5/6 p-3 sm:p-4 flex flex-col justify-between space-y-2 sm:space-y-3 md:space-y-4">
                    {{-- Title + Price --}}
                    <div class="flex flex-col sm:flex-row sm:justify-between gap-2">
                        <div class="flex-grow">
                            {{-- Brand --}}
                            @if(isset($product->brand->name))
                                <span class="text-xs font-medium uppercase tracking-wider text-gray-500 mb-1 block">{{ $product->brand->name }}</span>
                            @endif

                            <a href="{{ route('products.view', $product->slug) }}">
                                <h3 class="text-base sm:text-lg md:text-xl font-semibold text-slate-900 hover:text-primary transition-colors line-clamp-2">
                                    {{ $product->title }}
                                </h3>
                            </a>
                        </div>

                        {{-- Price --}}
                        <div class="flex items-center space-x-2 mt-1 sm:mt-0">
                            <template x-if="selectedSize">
                                <!-- Selected size price -->
                                <div class="flex items-center">
                                    <span class="text-lg sm:text-xl md:text-2xl font-bold text-slate-900" x-text="'€' + displayedPrice"></span>
                                    <!-- Original price for selected size -->
                                    <template x-if="selectedSize.originalPrice && selectedSize.originalPrice > selectedSize.price">
                                        <span class="text-xs sm:text-sm text-slate-500 line-through ml-2" x-text="'€' + parseFloat(selectedSize.originalPrice).toFixed(2)"></span>
                                    </template>
                                </div>
                            </template>
                            <template x-if="!selectedSize">
                                <div class="flex items-center space-x-2">
                                <span class="text-lg sm:text-xl md:text-2xl font-bold text-slate-900">
                                    €{{ number_format($minPrice, 2) }}
                                    @if($minPrice !== $maxPrice)
                                        - €{{ number_format($maxPrice, 2) }}
                                    @endif
                                </span>

                                    <!-- Show original price range -->
                                    @if($hasSizes)
                                        <template x-if="minOriginalPrice && minOriginalPrice > minPrice">
                                            <span class="text-xs sm:text-sm text-slate-500 line-through ml-2" x-text="`€${minOriginalPrice.toFixed(2)}${minOriginalPrice !== maxOriginalPrice ? ' - €' + maxOriginalPrice.toFixed(2) : ''}`"></span>
                                        </template>
                                    @else
                                        @if($hasDiscount)
                                            <span class="text-xs sm:text-sm text-slate-500 line-through ml-2">
                                            €{{ number_format($product->original_price, 2) }}
                                        </span>
                                        @endif
                                    @endif
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- Description --}}
                    <p class="text-gray-600 line-clamp-2 text-xs sm:text-sm">
                        {{ $product->description ? Str::limit(strip_tags($product->description), 120) : 'No description available.' }}
                    </p>

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        {{-- Size Select --}}
                        <div class="w-full sm:w-1/2 md:w-1/3">
                            @if($hasSizes)
                                <label class="text-xs sm:text-sm text-gray-600 font-medium block mb-1">Size:</label>
                                <select
                                    x-model="selectedSizeId"
                                    @change="selectSize($event.target.value)"
                                    class="block w-full border-gray-300 rounded-md text-xs sm:text-sm shadow-sm focus:ring-primary focus:border-primary"
                                >
                                    <option disabled selected value="">Choose size</option>
                                    @foreach($product->sizes as $size)
                                        <option value="{{ $size->id }}">
                                            {{ $size->name }} (€{{ number_format($size->pivot->price, 2) }})
                                        </option>
                                    @endforeach
                                </select>
                            @else
                                <div class="h-8 md:h-9"></div>
                            @endif
                        </div>

                        {{-- Add to Cart --}}
                        <div class="flex items-center justify-between sm:justify-end w-full sm:w-1/2 md:w-2/3 gap-3">
                        <span class="text-xs text-primary-400 italic sm:mr-3">
                            Loved by pets worldwide 🐾
                        </span>

                            <button
                                @click="addToCart(1)"
                                class="flex-shrink-0 inline-flex items-center justify-center rounded-md bg-primary px-3 py-2 sm:px-4 sm:py-2.5 text-xs sm:text-sm font-medium text-white hover:bg-primary-600 transition"
                                x-text="selectedSize || !product.sizes.length ? 'Add to cart' : 'Choose options'"
                            >
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <!-- Pagination -->
    <div class="mt-8">
        {{ $products->appends(request()->query())->links() }}
    </div>
</div>
