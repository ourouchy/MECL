@props(['categoryList'])

<div {{ $attributes->merge(['class' => 'mobile-category-list w-full h-full flex flex-col']) }}>
    <div class="category-header flex-shrink-0">
        <!-- Fixed Header Elements -->
        <li class="group border-l-4 border-transparent hover:border-secondary-500 transition-all duration-200">
            <a href="{{ route('home') }}" class="block py-4 px-3 text-xl font-medium flex items-center text-gray-800 hover:text-secondary-600 transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Home
            </a>
            <div class="mx-3 border-b border-gray-100"></div>
        </li>
        <li class="group border-l-4 border-transparent hover:border-secondary-500 transition-all duration-200">
            <a href="{{ route('products.index') }}" class="block py-4 px-3 text-xl font-medium flex items-center text-gray-800 hover:text-secondary-600 transition-colors duration-200">
                Shop
            </a>
            <div class="mx-3 border-b border-gray-100"></div>
        </li>
    </div>

    <div class="category-scrollable-container flex-grow overflow-y-auto">
        @if (!empty($categoryList))
            @foreach($categoryList as $category)
                <li x-data="{ open: false }"
                    class="group border-l-4 border-transparent hover:border-secondary-500 transition-all duration-200">

                    <div class="flex justify-between items-center">
                        <a href="{{ route('products.byCategory', $category) }}" class="block py-4 px-3 flex-grow text-xl font-medium text-gray-800 hover:text-secondary-600 transition-colors duration-200">
                            {{$category->name}}
                        </a>
                        @if(!empty($category->children))
                            <button @click.prevent.stop="open = !open" class="p-3 mr-2 flex items-center justify-center h-10 w-10 rounded-full text-gray-500 hover:text-secondary-600 hover:bg-secondary-50 transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transition-transform duration-300" :class="{'rotate-180': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        @endif
                    </div>

                    @if(!empty($category->children))
                        <ul x-show="open" x-collapse class="ml-4 pl-4 border-l-2 border-gray-200">
                            @foreach($category->children as $childCategory)
                                <li x-data="{ childOpen: false }">
                                    <div class="flex justify-between items-center">
                                        <a href="{{ route('products.byCategory', $childCategory) }}" class="block py-3 px-3 flex-grow text-lg text-gray-600 hover:text-secondary-600 transition-colors duration-200">
                                            {{$childCategory->name}}
                                        </a>
                                        @if(!empty($childCategory->children))
                                            <button @click.prevent.stop="childOpen = !childOpen" class="p-2 mr-2 flex items-center justify-center h-9 w-9 rounded-full text-gray-400 hover:text-secondary-600 hover:bg-secondary-50 transition-all duration-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform duration-300" :class="{'rotate-180': childOpen}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                    @if(!empty($childCategory->children))
                                        <ul x-show="childOpen" x-collapse class="ml-4 pl-4 border-l-2 border-gray-100">
                                            @foreach($childCategory->children as $grandChildCategory)
                                                <li>
                                                    <a href="{{ route('products.byCategory', $grandChildCategory) }}" class="block py-3 px-3 text-base text-gray-500 hover:text-secondary-600 transition-colors duration-200">
                                                        {{$grandChildCategory->name}}
                                                    </a>
                                                    @if(!$loop->last)
                                                        <div class="mx-6 border-b border-gray-50"></div>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                    @if(!$loop->last)
                                        <div class="mx-6 border-b border-gray-100"></div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="mx-3 border-b border-gray-200"></div>
                </li>
            @endforeach
        @endif
    </div>
</div>

<style>
    .mobile-category-list {
        display: flex;
        flex-direction: column;
        height: 100vh;
    }

    .category-header {
        position: sticky;
        top: 0;
        background-color: #ffffff;
        z-index: 10;
    }

    .category-scrollable-container {
        flex: 1;
        overflow-y: auto;
        -webkit-overflow-scrolling: touch;
    }
</style>
