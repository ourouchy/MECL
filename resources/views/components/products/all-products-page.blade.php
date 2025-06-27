@props(['products', 'categories', 'brands', 'newArrivals' => [], 'discountedProducts', 'breadcrumbs' => []])

<div class="container mx-auto px-4 mt-3">

    <x-breadcrumbs :breadcrumbs="$breadcrumbs"/>
    <x-products.carrousel/>

    <h2 class="text-2xl font-bold mb-6 text-neutral-800 mt-2">By Categories</h2>

    <div class="flex gap-4 overflow-x-auto scrollbar-hide scroll-smooth mt-6 pb-2">
        @forelse ($categories as $category)
            <a href="{{ route('products.byCategory', $category->slug) }}"
               class="relative min-w-[250px] max-w-[300px] rounded-lg overflow-hidden flex-shrink-0 group">
                <img
                    src="{{ asset('storage/' . $category->selection_image) }}"
                    alt="{{ $category->name }}"
                    class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300"
                >
                <div class="absolute inset-0 bg-gradient-to-r from-secondary/20 to-primary/10 flex items-center">
                    <div class="px-4">
                        <h2 class="text-white text-2xl font-bold mb-1">{{ strtoupper($category->name) }}</h2>
                    </div>
                </div>
            </a>
        @empty
            <p class="text-gray-500">Aucune catégorie disponible.</p>
        @endforelse
    </div>


    <!-- New Arrivals Section -->
    <div class="mt-12 mb-6">
        <h2 class="text-2xl font-bold text-neutral-800 mb-6">New Arrivals</h2>

        {{-- Mobile scrollable --}}
        <div class="block lg:hidden">
            <div class="flex overflow-x-auto snap-x snap-mandatory space-x-4 scrollbar-hide">
                @foreach ($newArrivals as $product)
                    <div class="flex-shrink-0 snap-start w-72">
                        <x-landing.product-card-preview :product="$product" />
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Desktop grid --}}
        <div class="hidden lg:grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            @foreach ($newArrivals as $product)
                <x-landing.product-card-preview :product="$product" />
            @endforeach
        </div>
    </div>


    <a href="" class="mt-12 relative rounded-lg overflow-hidden bg-white">
        <img src="{{ asset('images/baniere-promo.png') }}" alt="Purina Promo" class="w-full object-contain">
    </a>





@if($discountedProducts->count())
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-neutral-800 mb-6">Discounted Products</h2>

            {{-- Mobile scrollable --}}
            <div class="block lg:hidden">
                <div class="flex overflow-x-auto snap-x snap-mandatory space-x-4 scrollbar-hide">
                    @foreach ($discountedProducts as $product)
                        <div class="flex-shrink-0 snap-start w-72">
                            <x-landing.product-card-preview :product="$product" />
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Desktop grid --}}
            <div class="hidden lg:grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach ($discountedProducts as $product)
                    <x-landing.product-card-preview :product="$product" />
                @endforeach
            </div>
        </div>
    @endif
    <div class="mt-12">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold text-neutral-800">Brands</h2>
            <a href="{{ route('brands.index') }}" class="text-primary-600 hover:text-primary-700 text-sm flex items-center">
                View All <span class="ml-1">›</span>
            </a>
        </div>
        <p class="text-neutral-600 mb-6">
            We're proud to include {{ $brands->count() }}+ top premium brands worldwide.
        </p>

        <!-- Scrollable Brands -->
        <div class="flex gap-6 overflow-x-auto scroll-smooth pb-2 no-scrollbar">
            @foreach ($brands as $brand)
                <a href="{{ route('brands.show', $brand->slug) }}" class="bg-white rounded-lg flex items-center justify-center min-w-[120px] h-32 md:min-w-[160px] md:h-40 p-4 flex-shrink-0 hover:scale-105 transition-transform">
                    @if($brand->image)
                        <div class="flex items-center justify-center w-full h-full">
                            <img
                                src="{{ asset('storage/' . $brand->image) }}"
                                alt="{{ $brand->name }}"
                                class="w-28 h-28 md:w-36 md:h-36 object-contain"
                            >
                        </div>
                    @else
                        <span class="text-sm font-medium text-neutral-700 text-center">{{ $brand->name }}</span>
                    @endif
                </a>
            @endforeach
        </div>
    </div>



</div>
