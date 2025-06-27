@props([
    'title' => 'Featured Products',
    'products' => [],
    'viewAllLink' => null,
])

@php
    $products = collect($products)->take(8);
@endphp

<section class="py-12 bg-white">
    <div class="container">
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center">
                <div class="w-10 h-1 bg-primary rounded-full mr-4"></div>
                <h2 class="text-2xl font-bold">{{ $title }}</h2>
            </div>

            @if ($viewAllLink)
                <a
                    href="{{ $viewAllLink }}"
                    class="text-primary hover:text-primary-700 font-medium transition-colors"
                >
                    View All
                </a>
            @endif
        </div>

        {{-- Mobile (scrollable row) --}}
        <div class="block lg:hidden">
            <div
                class="flex overflow-x-auto snap-x snap-mandatory space-x-4 scrollbar-hide"
                x-data="scrollable()"
                x-init="init()"
                x-ref="scrollContainer"
                @scroll="checkArrows"
            >
                @foreach ($products as $product)
                    <div class="flex-shrink-0 snap-start w-72">
                        <x-landing.product-card-preview :product="$product" />
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Desktop grid --}}
        <div class="hidden lg:grid grid-cols-4 gap-6">
            @foreach ($products as $product)
                <x-landing.product-card-preview :product="$product" />
            @endforeach
        </div>
    </div>
</section>
