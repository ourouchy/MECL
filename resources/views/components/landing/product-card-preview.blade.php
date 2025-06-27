@php use Illuminate\Support\Carbon; @endphp
@props(['product'])

@php
    $hasSizes = isset($product->sizes) && count($product->sizes) > 0;
    $prices = $hasSizes
        ? collect($product->sizes)->pluck('pivot.price')->map(fn($p) => floatval($p))->toArray()
        : [];
    $minPrice = $prices ? min($prices) : $product->price;
    $maxPrice = $prices ? max($prices) : $product->price;
    $hasDiscount = $product->original_price && $product->original_price > $product->price;
    $discount = $hasDiscount
        ? round((($product->original_price - $product->price) / $product->original_price) * 100)
        : null;
    $badges = $product->badges ?? [];
    $isNew = $product->created_at && $product->created_at->greaterThan(Carbon::now()->subDays(15));
    $averageRating = $product->reviews->avg('rating') ?? 0;
    $reviewCount = $product->reviews->count();
@endphp


<div class="card group overflow-hidden transition-all duration-300 hover:shadow-lg relative flex flex-col border border-gray-200 bg-white w-full h-full"
    x-data="productItem({{ json_encode([
        'id' => $product->id,
        'slug' => $product->slug,
        'image' => $product->image ?: '/img/noimage.png',
        'title' => $product->title,
        'price' => $product->price,
        'brand' => $product->brand,
        'originalPrice' => $product->original_price ?? null,
        'addToCartUrl' => route('cart.add', $product),
        'sizes' => $hasSizes
            ? collect($product->sizes)->map(fn($size) => [
                'id' => $size->id,
                'name' => $size->name,
                'price' => $size->pivot->price,
                'originalPrice' => $size->pivot->original_price ?? null,
                'stock' => $size->pivot->stock,
            ])
            : [],
        'showSizes' => false
    ]) }})"
>
    {{-- Promo Discount Tag --}}
    @if($discount)
        <div class="absolute top-2 left-2 bg-secondary text-white text-xs font-bold px-2 py-1 rounded-md z-10">
            -{{ $discount }}%
        </div>
    @endif

    @if($isNew)
        <div class="absolute top-2 {{ $discount ? 'right-2' : 'left-2' }} bg-primary text-white text-xs font-semibold px-2 py-1 rounded-md z-10">
            New
        </div>
    @endif

    {{-- Badges --}}
    @if (!empty($badges))
        <div class="absolute top-2 right-2 flex flex-col gap-1 z-10">
            @foreach ($badges as $badge)
                <span class="bg-primary text-white text-xs px-2 py-1 rounded-md">{{ $badge }}</span>
            @endforeach
        </div>
    @endif

    {{-- Favorite button (non-functional) --}}
    <button
        class="absolute top-2 right-2 w-8 h-8 bg-white rounded-full flex items-center justify-center text-neutral-600
               hover:text-secondary transition-colors shadow-md opacity-0 group-hover:opacity-100 z-20"
        aria-label="Add to favorites"
    >
        ♥
    </button>

    {{-- Product image - Fixed height container --}}
    <a href="{{ route('products.view', $product->slug) }}" class="block overflow-hidden p-2 h-40 sm:h-44 md:h-48 flex items-center justify-center">
        <img
            :src="product.image"
            alt="{{ $product->title }}"
            class="max-h-full max-w-full object-contain transition-transform duration-300 group-hover:scale-105"
        />
    </a>

    {{-- Product info --}}
    <div class="p-3 sm:p-4 pt-2 flex flex-col flex-grow">
        <!-- Brand name -->
        @if(isset($product->brand->name))
            <span class="text-xs font-medium uppercase tracking-wider text-gray-800 mb-1 line-clamp-1">{{ $product->brand->name }}</span>
        @endif

        <!-- Product title - fixed height with line clamping -->
        <h3 class="font-semibold text-base sm:text-lg leading-tight mb-3 line-clamp-2 text-gray-800 h-10 sm:h-14">
            <a href="{{ route('products.view', $product->slug) }}" class="hover:text-primary transition-colors">
                {{ $product->title }}
            </a>
        </h3>

        {{-- Rating --}}
        <div class="flex items-center mb-2">
            @for ($i = 1; $i <= 5; $i++)
                <svg class="w-3 h-3 sm:w-4 sm:h-4 {{ $i <= round($averageRating) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.128 3.477a1 1 0 00.95.69h3.647c.969 0 1.371 1.24.588 1.81l-2.95 2.14a1 1 0 00-.364 1.118l1.128 3.477c.3.921-.755 1.688-1.54 1.118l-2.95-2.14a1 1 0 00-1.176 0l-2.95 2.14c-.784.57-1.838-.197-1.54-1.118l1.128-3.477a1 1 0 00-.364-1.118l-2.95-2.14c-.783-.57-.38-1.81.588-1.81h3.647a1 1 0 00.95-.69l1.128-3.477z"/>
                </svg>
            @endfor
            <span class="text-xs text-gray-600 ml-2">({{ $reviewCount }})</span>
        </div>

        {{-- Size selector - Only shown when showSizes is true --}}
        <div class="mt-1 mb-2 h-12" x-show="showSizes" x-transition x-cloak>
            @if($hasSizes)
                <label class="text-xs font-medium text-gray-600 block mb-1">Select Size:</label>
                <select
                    x-model="selectedSizeId"
                    @change="selectSize($event.target.value); showSizes = false"
                    class="mt-1 block w-full border-gray-300 rounded-md text-sm shadow-sm focus:ring-primary focus:border-primary"
                >
                    <option disabled selected value="">Choose size</option>
                    @foreach($product->sizes as $size)
                        <option value="{{ $size->id }}">
                            {{ $size->name }} (€{{ number_format($size->pivot->price, 2) }})
                        </option>
                    @endforeach
                </select>
            @endif
        </div>

        <!-- Size placeholder to maintain height when sizes not shown -->
        <div class="h-0 md:h-12" x-show="!showSizes"></div>

        <!-- Spacer to push price and button to bottom -->
        <div class="flex-grow min-h-4"></div>

        {{-- Price block - consistent height --}}
        <div class="mt-auto mb-3">
            <div class="flex flex-col items-start sm:items-center sm:flex-row sm:justify-between gap-1">
                <!-- Current Price -->
                <template x-if="selectedSize">
                    <p class="font-bold text-lg sm:text-xl text-primary-700" x-text="'€' + displayedPrice"></p>
                </template>
                <template x-if="!selectedSize">
                    <p class="font-bold text-lg sm:text-xl text-primary-700">
                        €{{ number_format($minPrice, 2) }}
                        @if($minPrice !== $maxPrice)
                            - €{{ number_format($maxPrice, 2) }}
                        @endif
                    </p>
                </template>

                <!-- Original Price (if discount) -->
                <template x-if="selectedSize && selectedSize.originalPrice && selectedSize.originalPrice > selectedSize.price">
                    <span class="text-sm text-gray-700 line-through" x-text="'€' + parseFloat(selectedSize.originalPrice).toFixed(2)"></span>
                </template>

                <template x-if="!selectedSize">
                    @if($hasSizes)
                        <template x-if="minOriginalPrice && minOriginalPrice > minPrice">
                            <span class="text-sm text-gray-700 line-through" x-text="`€${minOriginalPrice.toFixed(2)}${minOriginalPrice !== maxOriginalPrice ? ' - €' + maxOriginalPrice.toFixed(2) : ''}`"></span>
                        </template>
                    @else
                        @if($hasDiscount)
                            <span class="text-sm text-gray-700 line-through">
                        €{{ number_format($product->original_price, 2) }}
                    </span>
                        @endif
                    @endif
                </template>
            </div>
        </div>
        {{-- Add button --}}
        <button
            class="w-full bg-primary hover:bg-primary-600 text-white py-2 sm:py-2.5 text-sm font-semibold transition rounded-md"
            @click="product.sizes.length && !selectedSize ? (showSizes = !showSizes) : addToCart(1)"
            x-text="selectedSize || !product.sizes.length ? 'Add to cart' : 'Choose options'"
        ></button>
    </div>
</div>
