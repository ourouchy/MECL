<x-app-layout>
    @php
        $isCategoryPage = isset($category);
    @endphp
    @if($isCategoryPage)
        <x-products.category-page :category="$category" :products="$products"     :availableSizes="$availableSizes"
                                  :availablePriceRange="$availablePriceRange"
                                  :brands="$brands ?? []"
                                  :availableSizes="$availableSizes"
                                  :availablePriceRange="$availablePriceRange"
                                  :availableBrands="$availableBrands"
                                  :breadcrumbs="$breadcrumbs"


        />
    @else
        <x-products.all-products-page
            :products="$products"
            :categories="$categories ?? []"
            :brands="$brands ?? []"
            :newArrivals="$newArrivals"
            :discountedProducts="$discountedProducts"
            :breadcrumbs="$breadcrumbs"
        />
    @endif
</x-app-layout>

