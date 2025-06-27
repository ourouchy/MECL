<x-app-layout>

    <section class="py-10 container">
        <x-breadcrumbs :breadcrumbs="$breadcrumbs" />

        <h1 class="text-2xl font-bold text-gray-800 mb-6">
            Products by brand: {{ $brand->name }}
        </h1>

        @if($brand->image)
            <img src="{{ asset('storage/' . $brand->image) }}" alt="{{ $brand->name }}" class="h-24 mb-4 object-contain" />
        @endif

        @if($products->count())
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
                @foreach ($products as $product)
                    <x-landing.product-card-preview :product="$product" />
                @endforeach
            </div>

            <div class="mt-6">
                {{ $products->links() }}
            </div>
        @else
            <p class="text-gray-500">No products found for this brand.</p>
        @endif
    </section>
</x-app-layout>
