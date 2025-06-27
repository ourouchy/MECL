@props([
    'title' => 'Shop By Pet',
    'categories' => [
        [
            'id' => 'cat',
            'name' => 'Cat',
            'image' => '/images/cat.jpg',
            'link' => '#',
        ],
        [
            'id' => 'dog',
            'name' => 'Dog',
            'image' => '/images/dog.jpg',
            'link' => '#',
        ],
        // Add more mock categories or pass real data later
    ]
])

<section class="py-12 bg-gray-400">
    <div class="container">
        <div class="flex items-center justify-center mb-8">
            <div class="w-16 h-1 bg-primary rounded-full"></div>
            <h2 class="text-2xl font-bold text-center mx-4">{{ $title }}</h2>
            <div class="w-16 h-1 bg-primary rounded-full"></div>
        </div>

        {{-- Mobile scroll, hidden on lg --}}
        <div class="lg:hidden">
            <div
                class="flex overflow-x-auto snap-x snap-mandatory space-x-4 scrollbar-hide px-1"
                x-data="scrollable()"
                x-init="init()"
                x-ref="scrollContainer"
                @scroll="checkArrows"
            >
                @foreach ($categories as $category)
                    <a
                        href="{{ $category['link'] }}"
                        class="flex-shrink-0 snap-start w-40 flex flex-col items-center justify-center"
                    >
                        <div class="w-24 h-24 rounded-full overflow-hidden bg-white p-1 shadow-md
                                    transition-transform duration-300 hover:scale-105 mb-3">
                            <div
                                class="w-full h-full rounded-full bg-cover bg-center"
                                style="background-image: url('{{ $category['image'] ?? '' }}')"
                            >
                                @if (empty($category['image']))
                                    <div class="w-full h-full rounded-full bg-primary-100 flex items-center justify-center">
                                        {{-- Icon placeholder --}}
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-primary" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M5 8c1.38 0 2.5-1.12 2.5-2.5S6.38 3 5 3 2.5 4.12 2.5 5.5 3.62 8 5 8zm7 0c1.38 0 2.5-1.12 2.5-2.5S13.38 3 12 3s-2.5 1.12-2.5 2.5S10.62 8 12 8zm7 0c1.38 0 2.5-1.12 2.5-2.5S20.38 3 19 3s-2.5 1.12-2.5 2.5S17.62 8 19 8zm-10 5c1.38 0 2.5-1.12 2.5-2.5S10.38 8 9 8s-2.5 1.12-2.5 2.5S7.62 13 9 13zm6 0c1.38 0 2.5-1.12 2.5-2.5S16.38 8 15 8s-2.5 1.12-2.5 2.5S13.62 13 15 13z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <h3 class="text-center font-medium hover:text-primary transition-colors">
                            {{ $category['name'] }}
                        </h3>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Grid for large screens --}}
        <div class="hidden lg:grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-6">
            @foreach ($categories as $category)
                <a
                    href="{{ $category['link'] }}"
                    class="group flex flex-col items-center justify-center"
                >
                    <div class="w-24 h-24 md:w-32 md:h-32 rounded-full overflow-hidden bg-white p-1 shadow-md
                                transition-transform duration-300 group-hover:scale-105 mb-3">
                        <div
                            class="w-full h-full rounded-full bg-cover bg-center"
                            style="background-image: url('{{ $category['image'] ?? '' }}')"
                        >
                            @if (empty($category['image']))
                                <div class="w-full h-full rounded-full bg-primary-100 flex items-center justify-center">
                                    {{-- Icon placeholder --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-primary" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M5 8c1.38 0 2.5-1.12 2.5-2.5S6.38 3 5 3 2.5 4.12 2.5 5.5 3.62 8 5 8zm7 0c1.38 0 2.5-1.12 2.5-2.5S13.38 3 12 3s-2.5 1.12-2.5 2.5S10.62 8 12 8zm7 0c1.38 0 2.5-1.12 2.5-2.5S20.38 3 19 3s-2.5 1.12-2.5 2.5S17.62 8 19 8zm-10 5c1.38 0 2.5-1.12 2.5-2.5S10.38 8 9 8s-2.5 1.12-2.5 2.5S7.62 13 9 13zm6 0c1.38 0 2.5-1.12 2.5-2.5S16.38 8 15 8s-2.5 1.12-2.5 2.5S13.62 13 15 13z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </div>
                    <h3 class="text-center font-medium group-hover:text-primary transition-colors">
                        {{ $category['name'] }}
                    </h3>
                </a>
            @endforeach
        </div>
    </div>
</section>
