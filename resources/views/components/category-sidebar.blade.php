@props(['categories'])

<div
    x-data="productFilter()"
    class="bg-white border border-gray-200 rounded-lg p-4 w-64"
>
    <h3 class="text-lg font-semibold mb-4">Filter Products</h3>

    <!-- Category Filter -->
    <div class="mb-4">
        <h4 class="font-medium mb-2">Categories</h4>
        @foreach($categories as $category)
            <div class="mb-2">
                <label class="inline-flex items-center">
                    <input
                        type="checkbox"
                        :value="{{ $category->id }}"
                        x-model="selectedCategories"
                        @change="applyFilter"
                        class="form-checkbox"
                    >
                    <span class="ml-2">{{ $category->name }}</span>
                </label>

                @if($category->children && $category->children->count())
                    <div class="pl-4">
                        @foreach($category->children as $subcategory)
                            <div class="mb-1">
                                <label class="inline-flex items-center">
                                    <input
                                        type="checkbox"
                                        :value="{{ $subcategory->id }}"
                                        x-model="selectedCategories"
                                        @change="applyFilter"
                                        class="form-checkbox"
                                    >
                                    <span class="ml-2">{{ $subcategory->name }}</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <!-- Price Range Filter -->
    <div class="mb-4">
        <h4 class="font-medium mb-2">Price Range</h4>
        <div class="flex space-x-2">
            <input
                type="number"
                x-model="minPrice"
                @change="applyFilter"
                placeholder="Min"
                class="w-1/2 form-input"
            >
            <input
                type="number"
                x-model="maxPrice"
                @change="applyFilter"
                placeholder="Max"
                class="w-1/2 form-input"
            >
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function productFilter() {
            return {
                selectedCategories: [],
                minPrice: null,
                maxPrice: null,

                applyFilter() {
                    // Create a URL with filter parameters
                    const params = new URLSearchParams(window.location.search);

                    // Clear existing category and price filters
                    params.delete('categories[]');
                    params.delete('min_price');
                    params.delete('max_price');

                    // Add selected categories
                    this.selectedCategories.forEach(category => {
                        params.append('categories[]', category);
                    });

                    // Add price range
                    if (this.minPrice) {
                        params.set('min_price', this.minPrice);
                    }
                    if (this.maxPrice) {
                        params.set('max_price', this.maxPrice);
                    }

                    // Reload the page with new parameters
                    window.location.href = `${window.location.pathname}?${params.toString()}`;
                }
            }
        }
    </script>
@endpush
