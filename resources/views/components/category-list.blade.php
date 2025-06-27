@props(['categoryList'])

<div {{ $attributes->merge(['class' => 'category-list hidden md:flex items-center bg-gray-200 border-t border-gray-600']) }}>
    {{-- Home Link --}}
    <ul class="flex ml-20">
        <li>
            <a href="{{ route('home') }}" class="block px-4 py-3 text-neutral-700 hover:text-primary hover:bg-gray-300 transition-colors">
                Home
            </a>
        </li>
        <li>
            <a href="{{ route('products.index') }}" class="block px-4 py-3 text-neutral-700 hover:text-primary hover:bg-gray-300 transition-colors">
                Shop
            </a>
        </li>
        @foreach($categoryList as $category)
            <li class="relative group">
                <a href="{{ route('products.byCategory', $category) }}"
                   class="block px-4 py-3 text-neutral-700 hover:text-primary hover:bg-gray-300 transition-colors flex items-center">
                    {{ $category->name }}
                    @if(!empty($category->children))
                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-4 w-4" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 9l-7 7-7-7"/>
                        </svg>
                    @endif
                </a>

                {{-- Dropdown menu --}}
                @if(!empty($category->children))
                    <ul
                        class="absolute left-0 top-full z-50 w-64 bg-white shadow-lg p-2 hidden group-hover:block transition duration-150 ease-in-out">
                        @foreach($category->children as $child)
                            <li class="group relative">
                                <a href="{{ route('products.byCategory', $child) }}"
                                   class="flex justify-between items-center px-3 py-2 hover:bg-gray-100 text-gray-800 hover:text-primary-600 transition">
                                    {{ $child->name }}
                                    @if(!empty($child->children))
                                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-4 w-4"
                                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M9 5l7 7-7 7"/>
                                        </svg>
                                    @endif
                                </a>

                                {{-- Grandchild dropdown --}}
                                @if(!empty($child->children))
                                    <ul
                                        class="absolute left-full top-0 w-64 bg-white shadow-lg p-2 hidden group-hover:block transition duration-150 ease-in-out z-50">
                                        @foreach($child->children as $grandchild)
                                            <li>
                                                <a href="{{ route('products.byCategory', $grandchild) }}"
                                                   class="block px-3 py-2 hover:bg-gray-100 text-gray-800 hover:text-primary-600 transition">
                                                    {{ $grandchild->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach

    </ul>
</div>
