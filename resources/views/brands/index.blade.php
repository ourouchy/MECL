<x-app-layout>

    <div class="container py-8">
        <x-breadcrumbs :breadcrumbs="$breadcrumbs" />

        <h1 class="text-3xl font-bold text-secondary-700 mb-6">All Brands</h1>

        <!-- 🏆 Popular Brands Section -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Popular Brands</h2>
            <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-6">
                @foreach ($brands->shuffle()->take(6) as $popularBrand)
                    <a href="{{ route('brands.show', $popularBrand) }}" class="flex flex-col items-center group">
                        @if ($popularBrand->image)
                            <img src="{{ asset('storage/' . $popularBrand->image) }}" alt="{{ $popularBrand->name }}" class="h-16 object-contain mb-2 transition-transform duration-300 group-hover:scale-105">
                        @else
                            <div class="h-16 w-16 flex items-center justify-center bg-gray-100 text-gray-400 rounded-full mb-2">
                                <span class="text-sm">No image</span>
                            </div>
                        @endif
                        <span class="text-gray-700 text-sm group-hover:text-secondary-600">{{ $popularBrand->name }}</span>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Alphabetical navigation -->
        <div class="flex flex-wrap gap-4 border-b pb-4 mb-8">
            <a href="#" class="text-gray-700 hover:text-secondary-600">All</a>
            @foreach (range('A', 'Z') as $letter)
                <a href="#{{ $letter }}" class="text-gray-700 hover:text-secondary-600">{{ $letter }}</a>
            @endforeach
            <a href="#other" class="text-gray-700 hover:text-secondary-600">#</a>
        </div>

        <!-- Brands grouped by letter -->
        @php
            $groupedBrands = $brands->groupBy(function($brand) {
                return strtoupper(substr($brand->name, 0, 1));
            })->sortKeys();
        @endphp

        @foreach ($groupedBrands as $letter => $letterBrands)
            <div id="{{ $letter }}" class="mb-12">
                <h2 class="text-4xl text-gray-700 font-medium mb-6">{{ $letter }}</h2>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    @foreach ($letterBrands->chunk(ceil($letterBrands->count() / 4)) as $columnBrands)
                        <div>
                            @foreach ($columnBrands as $brand)
                                <div class="flex items-center mb-4 gap-3">
                                    @if ($brand->image)
                                        <img src="{{ asset('storage/' . $brand->image) }}" alt="{{ $brand->name }}" class="h-10 w-10 object-contain">
                                    @else
                                        <div class="h-10 w-10 flex items-center justify-center bg-gray-100 text-gray-400 rounded-full">
                                            <span class="text-xs">No image</span>
                                        </div>
                                    @endif
                                    <a href="{{ route('brands.show', $brand) }}" class="text-secondary-600 hover:text-secondary-800">
                                        {{ $brand->name }}
                                        @if ($brand->featured)
                                            <span class="text-primary-500 ml-1">★</span>
                                        @endif
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

</x-app-layout>
