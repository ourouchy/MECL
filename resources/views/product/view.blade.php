<x-app-layout>
    <main class="mt-10">
        <div class="container mx-auto px-4">
            <div class="flex justify-start mb-4">
                <x-breadcrumbs :breadcrumbs="$breadcrumbs"/>
            </div>
        </div>
        <div
            x-data="productItem({{ json_encode([
                'id' => $product->id,
                'slug' => $product->slug,
                'image' => $product->image ?: '/img/noimage.png',
                'title' => $product->title,
                'price' => $product->price,
                'quantity' => $product->quantity,
                'brand' => $product->brand,
                'addToCartUrl' => route('cart.add', $product),
                'sizes' => $product->sizes->map(function($size) {
                    return [
                        'id'    => $size->id,
                        'name'  => $size->name,
                        'price' => $size->pivot->price,
                                'originalPrice' => $size->pivot->original_price ?? null,
                        'stock' => $size->pivot->stock,
                    ];
                })->toArray()
            ]) }})"
            class="container mx-auto flex flex-col lg:flex-row gap-8">

            {{-- LEFT COLUMN --}}
            <div class="w-full lg:w-2/3">
                {{-- Image Gallery --}}
                <div
                    x-data="{
                        images: {{ $product->images->count()
                            ? $product->images->map(fn($im) => $im->url)
                            : json_encode(['/img/noimage.png']) }},
                        activeImage: null,
                        init() {
                            this.activeImage = this.images[0];
                        }
                    }"
                    class="bg-white rounded-lg shadow p-4 mb-6"
                >
                    {{-- Main Image --}}
                    <div class="relative w-full h-[400px] flex items-center justify-center mb-4">
                        <template x-for="image in images" :key="image">
                            <img x-show="activeImage === image" :src="image" alt="" class="max-h-full object-contain transition-transform duration-300" />
                        </template>
                    </div>

                    {{-- Thumbnail Navigation --}}
                    <div class="flex gap-2">
                        <template x-for="image in images" :key="image">
                            <button
                                @click.prevent="activeImage = image"
                                class="w-[80px] h-[80px] flex items-center justify-center border rounded-md overflow-hidden"
                                :class="{ 'border-primary': activeImage === image }"
                            >
                                <img :src="image" alt="" class="object-contain max-h-full" />
                            </button>
                        </template>
                    </div>
                </div>

                {{-- Description --}}
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-primary mb-4">Description</h2>
                    <div class="text-black prose max-w-none">
                        {!! $product->description !!}
                    </div>
                </div>
            </div>

            {{-- RIGHT COLUMN (Sticky Block) --}}
            <div class="w-full lg:w-1/3">
                <div class="sticky top-28 bg-white p-6 rounded-lg shadow-card space-y-6">
                    {{-- Title --}}
                    <h1 class="text-2xl font-bold text-neutral-800">{{ $product->title }}</h1>
                    @if ($product->brand)
                        <a href="/brands/{{ Str::slug($product->brand->name) }}" class="text-1xl font-bold text-gray-800">
                            {{ $product->brand->name }}
                        </a>
                    @else
                        <span class="text-gray-500 text-sm">No brand</span>
                    @endif

                    {{-- Reviews --}}
                    @php
                        $averageRating = $product->reviews->avg('rating') ?? 0;
                        $reviewCount = $product->reviews->count();
                    @endphp
                    <div class="flex items-center space-x-1 mt-2">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-4 h-4 {{ $i <= round($averageRating) ? 'text-yellow-400' : 'text-neutral-300' }}"
                                 fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.128 3.477a1 1 0 00.95.69h3.647c.969 0 1.371 1.24.588 1.81l-2.95 2.14a1 1 0 00-.364 1.118l1.128 3.477c.3.921-.755 1.688-1.54 1.118l-2.95-2.14a1 1 0 00-1.176 0l-2.95 2.14c-.784.57-1.838-.197-1.54-1.118l1.128-3.477a1 1 0 00-.364-1.118l-2.95-2.14c-.783-.57-.38-1.81.588-1.81h3.647a1 1 0 00.95-.69l1.128-3.477z"/>
                            </svg>
                        @endfor
                        <span class="text-xs text-neutral-500 ml-1">({{ $reviewCount }} reviews)</span>
                    </div>


                    {{-- Size Selector (Toggle style) --}}
                    <template x-if="product.sizes.length > 0">
                        <div>
                            <label class="block font-medium mb-2 text-neutral-700">Size:</label>
                            <div class="flex flex-wrap gap-2">
                                <template x-for="sz in product.sizes" :key="sz.id">
                                    <button
                                        type="button"
                                        @click="selectedSizeId = sz.id"
                                        class="px-4 py-1.5 border text-sm rounded-md transition-all"
                                        :class="selectedSizeId === sz.id
                                ? 'bg-primary-50 text-primary-700 border-primary-500'
                                : 'bg-white text-neutral-800 border-gray-300 hover:border-primary-300'"
                                        x-text="sz.name"
                                    ></button>
                                </template>
                            </div>
                        </div>
                    </template>

                    {{-- Price --}}
                    <div>
                        <label class="block font-medium mb-1 text-neutral-700">Price:</label>

                        {{-- Price for selected size --}}
                        <template x-if="selectedSize">
                            <div class="flex items-center gap-2">
            <span class="text-primary-600 text-2xl font-semibold">
                €<span x-text="parseFloat(selectedSize.price).toFixed(2)"></span>
            </span>

                                <template x-if="selectedSize.originalPrice && parseFloat(selectedSize.originalPrice) > parseFloat(selectedSize.price)">
                <span class="text-neutral-500 line-through text-lg">
                    €<span x-text="parseFloat(selectedSize.originalPrice).toFixed(2)"></span>
                </span>
                                </template>

                                <template x-if="selectedSize.originalPrice && parseFloat(selectedSize.originalPrice) > parseFloat(selectedSize.price)">
                <span class="ml-2 text-xs font-semibold bg-secondary text-white px-2 py-0.5 rounded">
                    <span x-text="Math.round((1 - parseFloat(selectedSize.price) / parseFloat(selectedSize.originalPrice)) * 100)"></span>% OFF
                </span>
                                </template>
                            </div>
                        </template>

                        {{-- Price Range when no size selected --}}
                        {{-- Price Range when no size selected --}}
                        <template x-if="!selectedSize">
                            <div class="flex flex-col gap-1">
                                {{-- Current price range --}}
                                <div class="text-primary-600 text-2xl font-semibold">
                                    <template x-if="product.sizes.length">
                                        <span x-text="`€${minPrice.toFixed(2)}${minPrice !== maxPrice ? ` - €${maxPrice.toFixed(2)}` : ''}`"></span>
                                    </template>
                                    <template x-if="!product.sizes.length">
                                        <span>
                                            €<span x-text="product.price ? parseFloat(product.price).toFixed(2) : '0.00'"></span>
                                        </span>
                                    </template>
                                </div>

                                {{-- Original price range + discount --}}
                                <template x-if="hasOriginalPriceRange">
                                    <div class="flex items-center gap-2">
                <span class="text-neutral-500 line-through text-lg">
                    <span x-text="`€${minOriginalPrice.toFixed(2)}${minOriginalPrice !== maxOriginalPrice ? ` - €${maxOriginalPrice.toFixed(2)}` : ''}`"></span>
                </span>
                                        <template x-if="averageDiscount > 0">
                    <span class="text-xs font-semibold bg-secondary text-white px-2 py-0.5 rounded">
                        <span x-text="averageDiscount"></span>% OFF
                    </span>
                                        </template>
                                    </div>
                                </template>

                                {{-- Original pricing for products without sizes --}}
                                <template x-if="!product.sizes.length && product.original_price && parseFloat(product.original_price) > parseFloat(product.price)">
                                    <div class="flex items-center gap-2">
                <span class="text-neutral-500 line-through text-lg">
                    £<span x-text="parseFloat(product.original_price).toFixed(2)"></span>
                </span>
                                        <span class="text-xs font-semibold bg-secondary text-white px-2 py-0.5 rounded">
                    <span x-text="Math.round((1 - parseFloat(product.price) / parseFloat(product.original_price)) * 100)"></span>% OFF
                </span>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>
                    {{-- Quantity Selector --}}
                    <div>
                        <label class="block font-medium mb-1 text-neutral-700">Quantity:</label>
                        <div class="flex items-center border rounded-md w-max">
                            <button type="button" @click="$refs.quantityEl.stepDown()"
                                    class="px-3 text-xl text-neutral-700 hover:text-secondary">−</button>
                            <input
                                type="number"
                                min="1"
                                value="1"
                                x-ref="quantityEl"
                                class="w-14 text-center border-0 focus:ring-0"
                            />
                            <button type="button" @click="$refs.quantityEl.stepUp()"
                                    class="px-3 text-xl text-neutral-700 hover:text-secondary">+</button>
                        </div>
                    </div>

                    {{-- Purchase Type --}}
                    <div>
                        <label class="block font-medium mb-2 text-neutral-700">Purchase Options</label>
                        <div class="space-y-2 text-sm">
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="purchaseType" checked class="text-secondary focus:ring-secondary">
                                <span>One-time purchase <strong x-text="'£' + (displayedPrice || product.price)"></strong></span>
                            </label>
                            <label class="flex items-center space-x-2 text-gray-900 cursor-not-allowed">
                                <input type="radio" name="purchaseType" disabled class="text-secondary focus:ring-secondary">
                                <span>Subscribe &amp; save up to 2% <span class="font-medium" x-text="'£' + ((displayedPrice || product.price) * 0.98).toFixed(2)"></span></span>
                            </label>
                            <span class="text-sm text-neutral-500 block pl-6 italic">Coming soon</span>
                        </div>
                    </div>

                    {{-- Stock Info --}}
                    @if ($product->quantity === 0)
                        <div class="bg-red-100 text-red-700 px-4 py-2 rounded text-center">
                            This product is out of stock
                        </div>
                    @endif

                    {{-- Add to Cart Button --}}
                    <button
                        :disabled="product.quantity === 0 || (product.sizes && product.sizes.length > 0 && !selectedSize)"
                        @click="addToCart($refs.quantityEl.value, selectedSizeId || '')"
                        class="w-full bg-secondary hover:bg-secondary-700 text-white font-semibold py-3 rounded-md transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                        x-text="product.sizes && product.sizes.length > 0 && !selectedSize ? 'Select size first' : 'Add to cart'"
                    >
                    </button>
                </div>
            </div>
        </div>

        @if($relatedProducts->count())
            <section class="mt-12">
                <div class="container">
                    <h2 class="text-2xl font-bold mb-6">You might also like</h2>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-4 gap-6">
                        @foreach($relatedProducts as $related)
                            <x-landing.product-card-preview :product="$related" />
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

    </main>
    <div class="mt-10">

        {{-- Average Rating --}}


        {{-- Individual Reviews --}}
        <div class="mt-12 container mx-auto px-4" x-data="{ showReviewForm: false }">
            <h2 class="text-xl font-bold text-primary-600 mb-4 text-center">Customer Reviews ({{ $product->reviews->count() }})</h2>

            @php
                $ratingCount = $product->reviews->count();
                $averageRating = $ratingCount > 0 ? round($product->reviews->avg('rating'), 1) : 0;

                $ratingDistribution = [];
                foreach (range(1, 5) as $star) {
                    $count = $product->reviews->where('rating', $star)->count();
                    $ratingDistribution[$star] = $ratingCount ? round(($count / $ratingCount) * 100) : 0;
                }
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 mt-6">
                {{-- Left Column: Summary --}}
                <div class="space-y-4">
                    <div class="text-xl font-semibold text-yellow-500 flex items-center justify-center">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5 {{ $i <= round($averageRating) ? 'fill-current' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c..."/>
                            </svg>
                        @endfor
                        <span class="ml-2 text-gray-700">{{ $averageRating }} based on {{ $ratingCount }} reviews</span>
                    </div>

                    @foreach (range(5, 1) as $star)
                        <div class="flex items-center space-x-2">
                            <span class="text-sm font-medium text-gray-700 w-5">{{ $star }}</span>
                            <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c..."/></svg>
                            <div class="w-full bg-gray-200 rounded h-2">
                                <div class="h-full bg-yellow-400 rounded" style="width: {{ $ratingDistribution[$star] }}%"></div>
                            </div>
                            <span class="text-sm text-gray-500">{{ $ratingDistribution[$star] }}%</span>
                        </div>
                    @endforeach


                </div>

                {{-- Right Column: Reviews --}}
                <div class="md:col-span-2 space-y-6">
                    @forelse ($product->reviews->sortByDesc('created_at') as $review)
                        <div class="border border-gray-200 rounded-md p-5 bg-white shadow-sm">
                            <div class="flex items-center mb-2 space-x-3">
                                <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center font-bold text-gray-600 uppercase">
                                    {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $review->user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="flex text-yellow-400 mb-1">
                                @for ($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= $review->rating ? 'fill-current' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c..."/>
                                    </svg>
                                @endfor
                            </div>
                            <p class="text-sm text-gray-700 mt-1">{{ $review->comment }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-gray-600 text-center">No reviews yet. Be the first to leave one!</p>
                    @endforelse
                </div>
            </div>

            {{-- Review Form --}}
            @auth
                @if (auth()->user()->hasPurchasedProduct($product->id))
                    <div x-data="{ showReviewForm: false }" class="mt-10 max-w-xl mx-auto">
                        <button
                            @click="showReviewForm = !showReviewForm"
                            class="inline-block px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-primary hover:bg-gray-50 transition"
                        >
                            Write a Review
                        </button>

                        <div x-show="showReviewForm" x-transition class="mt-6 bg-white p-6 rounded shadow" id="review-form">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Leave a Review</h3>

                            <form action="{{ route('products.reviews.store', $product) }}" method="POST" class="space-y-4">
                                @csrf

                                <!-- Rating -->
                                <div>
                                    <label for="rating" class="block text-sm font-medium text-gray-700">Rating</label>
                                    <select name="rating" id="rating" required class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                        <option value="">Select rating</option>
                                        @for ($i = 1; $i <= 5; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <!-- Comment -->
                                <div>
                                    <label for="comment" class="block text-sm font-medium text-gray-700">Comment</label>
                                    <textarea name="comment" id="comment" rows="4" required class="mt-1 w-full border-gray-300 rounded-md shadow-sm"></textarea>
                                </div>

                                <!-- Submit -->
                                <div class="text-right">
                                    <button type="submit" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-primary-600 transition">
                                        Submit Review
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @else
                    <p class="text-sm text-gray-600 mt-6 text-center italic">
                        Only verified buyers can leave a review.
                    </p>
                @endif
            @else

            @endauth
            @guest
                <p class="text-sm text-center text-gray-600 mt-6">
                    <a href="{{ route('login') }}" class="text-primary hover:underline">Log in</a> to leave a review.
                </p>
            @endguest
        </div>
    </div>
</x-app-layout>
