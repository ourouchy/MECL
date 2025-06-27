<x-app-layout>
    <div class="flex">
        <!-- Left Sidebar Filters -->
        <x-products.sidebar-filters />

        <!-- Right Content Area -->
        <div class="md:w-3/4 w-full flex flex-col">

            <!-- Top Banner Section -->
            <x-products.category-banner :category="$category ?? null" />

            <!-- Product List and Sorting -->
            <div class="p-3 border flex-grow">
                <!-- Sorting Dropdown & Mobile Filters Button -->
                <x-products.sorting-bar :products="$products" />

                <!-- No Products Message -->
                @if ($products->count() === 0)
                    <x-products.no-products />
                @else
                    <!-- View Toggle + Grid/List Switcher -->
                    <x-products.view-toggle :products="$products" />
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

<!-- JS Scripts -->
@push('scripts')
    <x-products.price-slider-script />
@endpush
