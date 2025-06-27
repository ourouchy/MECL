@props([
    'dogTitle' => 'Dog Treats',
    'catTitle' => 'Cat Treats',
    'products' => [],
    'dogImage' => '/images/treatdog.png',
    'catImage' => '/images/wet-cat-treats-1.jpg',
    'dogViewAllLink' => null,
    'catViewAllLink' => null,
])

@php
    // Pour l'instant, utilisons tous les produits sans filtrage
    $allProducts = collect($products)->take(4);
@endphp

<section class="py-16 bg-gray-50">
    <div class="container">
        {{-- Dog Treats Section (Image Left, Products Right) --}}
        <div class="mb-16">
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center">
                    <div class="w-10 h-1 bg-primary rounded-full mr-4"></div>
                    <h2 class="text-2xl font-bold">{{ $dogTitle }}</h2>
                </div>

                @if ($dogViewAllLink)
                    <a
                        href="{{ $dogViewAllLink }}"
                        class="text-primary hover:text-primary-700 font-medium transition-colors"
                    >
                        View All
                    </a>
                @endif
            </div>

            <div class="flex flex-col lg:flex-row items-center">
                {{-- Image on Left (Mobile: Top) --}}
                <div class="w-full lg:w-1/3 relative mb-8 lg:mb-0">
                    <div class="relative z-10">
                        <img
                            src="{{ $dogImage }}"
                            alt="Dog Treats"
                            class="rounded-xl shadow-lg w-full h-auto object-cover"
                            style="max-height: 450px;"
                        />
                    </div>
                    <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-primary-100 rounded-full opacity-50 z-0"></div>
                    <div class="absolute -top-4 -left-4 w-16 h-16 bg-primary-200 rounded-full opacity-50 z-0"></div>
                </div>

                {{-- Products on Right (Mobile: Bottom) --}}
                <div class="w-full lg:w-2/3 lg:pl-12 relative">
                    {{-- Decorative Element --}}
                    <div class="absolute top-1/2 left-0 transform -translate-y-1/2 w-16 h-2 bg-primary-200 rounded-full hidden lg:block"></div>

                    <div
                        class="overflow-x-auto snap-x snap-mandatory scrollbar-hide pl-4"
                        x-data="scrollable()"
                        x-init="init()"
                        x-ref="scrollContainer"
                        @scroll="checkArrows"
                    >
                        <div class="flex space-x-6">
                            @foreach ($allProducts as $product)
                                <div class="flex-shrink-0 snap-start" style="min-width: 250px; max-width: 250px;">
                                    <x-landing.product-card-preview :product="$product" />
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Cat Treats Section (Products Left, Image Right) --}}
        <div>
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center">
                    <div class="w-10 h-1 bg-secondary rounded-full mr-4"></div>
                    <h2 class="text-2xl font-bold">{{ $catTitle }}</h2>
                </div>

                @if ($catViewAllLink)
                    <a
                        href="{{ $catViewAllLink }}"
                        class="text-secondary hover:text-secondary-700 font-medium transition-colors"
                    >
                        View All
                    </a>
                @endif
            </div>

            <div class="flex flex-col-reverse lg:flex-row items-center">
                {{-- Products on Left (Mobile: Bottom) --}}
                <div class="w-full lg:w-2/3 lg:pr-12 relative">
                    {{-- Decorative Element --}}
                    <div class="absolute top-1/2 right-0 transform -translate-y-1/2 w-16 h-2 bg-secondary-200 rounded-full hidden lg:block"></div>

                    <div
                        class="overflow-x-auto snap-x snap-mandatory scrollbar-hide pr-4"
                        x-data="scrollable()"
                        x-init="init()"
                        x-ref="scrollContainer"
                        @scroll="checkArrows"
                    >
                        <div class="flex space-x-6">
                            @foreach ($allProducts as $product)
                                <div class="flex-shrink-0 snap-start" style="min-width: 250px; max-width: 250px;">
                                    <x-landing.product-card-preview :product="$product" />
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Image on Right (Mobile: Top) --}}
                <div class="w-full lg:w-1/3 relative mb-8 lg:mb-0">
                    <div class="relative z-10">
                        <img
                            src="{{ $catImage }}"
                            alt="Cat Treats"
                            class="rounded-xl shadow-lg w-full h-auto object-cover"
                            style="max-height: 450px;"
                        />
                    </div>
                    <div class="absolute -bottom-4 -left-4 w-24 h-24 bg-secondary-100 rounded-full opacity-50 z-0"></div>
                    <div class="absolute -top-4 -right-4 w-16 h-16 bg-secondary-200 rounded-full opacity-50 z-0"></div>
                </div>
            </div>
        </div>
    </div>
</section>
