<?php
/** @var \Illuminate\Database\Eloquent\Collection $products */
$categoryList = \App\Models\Category::getActiveAsTree();
?>


    <!-- MAIN -->

<main x-data="{ right: false, left: false, cartItemsCount: {{\App\Helpers\Cart::getCartItemsCount()}} }"
      @cart-change.window="
      console.log('Catching cart-change!', $event.detail);
      cartItemsCount = $event.detail.count
      "
      @body:right.window="right = !right" @body:left.window="left = !left" @body:reset.window="left = false; right = false" :class="{ '-translate-x-full md:-translate-x-120' : left, 'translate-x-full md:translate-x-120' : right }" class="fixed bg-white w-full transform translate-x-0 transition-transform duration-500 ease z-30 mb-28">
    <!-- OVERLAY -->
    <div x-data="{ isActive: false }" @overlay:open.window="isActive = true" @overlay:close.window="isActive = false" :class="{ 'opacity-75 visible' : isActive, 'opacity-0 invisible' : !isActive }" class="absolute inset-0 w-full h-full opacity-0 invisible z-20 transition-all duration-500 ease"></div>

    <!-- SIDEBARS -->

    <!-- mobile menu -->
    <nav x-data="sidebar" x-bind="setup" @mobile-sidebar:open.window="open()" @mobile-sidebar:close.window="close()" x-cloak data-position="left"
         class="fixed top-0 flex flex-col pb-72 w-full md:w-120 h-[calc(100vh)] text-gray-900 bg-white shadow transform z-50">

        <header class="relative p-6 pt-6 pb-0 text-center">
            <div class="flex justify-between">
                <button x-data @click="$dispatch('mobile-sidebar:close')" class="bottom-0 left-6 transform animate-boing hover:text-primary-500 transition-transform,transition-colors ease">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                    </svg>
                </button>
                <a class="mr-14">
                    <img class="max-h-14 pr-1" src="{{ asset('images/logo.png') }}" alt="friandos">
                </a>
            </div>
        </header>

        <ul class="flex flex-col p-6 pb-0">
            <!-- Replace static menu with dynamic categories -->
            <x-mobile-category-list :category-list="$categoryList" />

            <!-- Keep your other menu items -->
            <li class="">
                <a href="#" class="block p-3 text-xl transform scale-100 hover:scale-105 hover:text-primary-500 hover:bg-gray-100 hover:shadow transition-transform,transition-colors duration-300 ease rounded">About</a>
            </li>
        </ul>

    </nav>
    <!-- cart menu -->
    <nav x-data="sidebar" x-bind="setup" @cart-sidebar:open.window="open()" @cart-sidebar:close.window="close()" x-cloak data-position="right"
         class="fixed top-0 flex flex-col pb-72 w-full md:w-120 h-[calc(100vh)] text-gray-900 bg-white shadow transform z-50"
    >
        @php
            // Retrieve the mini-cart data from your Cart helper.
            $miniCart = \App\Helpers\Cart::getMiniCart();
        @endphp

            <!-- Cart Sidebar -->
        <nav x-data="miniCart({{ json_encode($miniCart) }})"
             x-cloak data-position="right"
             class="fixed top-0 flex flex-col pb-72 w-full md:w-120 h-[calc(100vh)] text-gray-900 bg-white shadow transform z-50">

            <!-- Sidebar Header -->
            <header class="p-6 border-b relative">
                <h2 class="text-lg font-semibold">Your Cart</h2>
                <button @click="$dispatch('cart-sidebar:close')" class="absolute top-4 right-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 hover:text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </header>

            <!-- Cart Items List -->
            <div class="flex-1 overflow-y-auto">
                <template x-if="cartItems.length > 0">
                    <template x-for="item in cartItems" :key="item.id">
                        <div class="flex p-4 border-b">
                            <img :src="item.image" alt="" class="w-16 h-16 object-cover rounded mr-4">
                            <div class="flex-1">
                                <h3 x-text="item.title" class="font-medium"></h3>

                                <template x-if="item.size_name">
                                    <p class="text-xs text-gray-800 mt-1">Taille: <span x-text="item.size_name"></span></p>
                                </template>

                                <p class="text-sm text-gray-800 mt-1">Quantité: <span x-text="item.quantity"></span></p>
                            </div>
                            <div class="font-semibold">€<span x-text="(item.price * item.quantity).toFixed(2)"></span></div>
                        </div>
                    </template>
                </template>
                <template x-if="cartItems.length === 0">
                    <div class="p-4 text-center text-gray-500">
                        Your cart is empty.
                    </div>
                </template>
            </div>

            <!-- Sidebar Footer / Order Summary -->
            <footer class="p-6 border-t">
                <div class="flex justify-between font-semibold">
                    <span>Total</span>
                    <span>€<span x-text="cartTotal"></span></span>
                </div>
                <a href="{{ route('cart.index') }}" class="block mt-4 bg-primary-600 text-white py-3 rounded text-center">
                    View Cart
                </a>
            </footer>
        </nav>

    </nav>

    <!-- HEADER -->
    <header class="p-1 px-5 sm:px-10 flex items-center justify-between text-gray-900 z-30 sm:ml-12 sm:mr-12">
        <div class="md:hidden">

            <!-- toggle mobile menu -->
            <button x-data @click="$dispatch('mobile-sidebar:open'); console.log('button clicked')" class="inline-block hover:text-primary-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>


        <!-- Logo -->
        <div class="pt-3 pl-3 pb-3 ml-0">
            <a href="{{route('home')}}" class="py-navbar-item w-56 h-12">
                <img class="h-14 pr-1" src="{{ asset('images/logo.png') }}" alt="friandos">
            </a>
        </div>
        <form x-data="liveSearchComponent()" class="w-3/6 mx-auto hidden sm:block border border-gray-700 rounded">
            <label for="desktop-search" class="mb-2 text-sm font-medium   sr-only dark:text-white ">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none ">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400 hover:text-primary-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input
                    type="search"
                    id="desktop-search"
                    x-model="searchTerm"
                    @input.debounce.300ms="fetchResults"
                    @focus="showDropdown = true"
                    class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Rechercher..."
                />

            </div>

            <!-- Dropdown Results -->
            <div
                x-show="showDropdown && results.length > 0"
                @click.away="showDropdown = false; searchTerm = ''"
                x-transition:enter="transition-opacity transition-transform ease-out duration-200 scale-95"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition-opacity ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="absolute z-10 mt-2 w-3/6 bg-white border border-gray-100 rounded-lg shadow-lg overflow-hidden"
                x-cloak
            >
                <ul class="max-h-96 overflow-y-auto">
                    <template x-for="product in results" :key="product.id">
                        <li
                            x-data="productItem({
                        id: product.id,
                        slug: product.slug,
                        title: product.title,
                        description: product.description,
                        price: product.price,
                        image: product.image_url || product.image || '/img/noimage.png',
                        addToCartUrl: `/cart/add/${product.slug}`
                    })"
                            class="border-b border-gray-100 last:border-b-0 hover:bg-gray-50 transition-colors duration-150"
                        >
                            <div class="p-4 flex items-center justify-between">
                                <div class="flex items-center gap-3 max-w-[70%]">
                                    <a :href="`/products/${product.slug}`">
                                        <img
                                            class="w-16 h-16 min-w-16 object-cover rounded-md border border-gray-200 shadow-sm hover:scale-105 transition-transform"
                                            :src="product.image"
                                            alt="Product"
                                        />
                                    </a>
                                    <div class="flex flex-col overflow-hidden">
                                        <a :href="`/products/${product.slug}`" class="font-medium text-gray-800 hover:text-primary-600 transition-colors truncate">
                                            <span x-text="product.title"></span>
                                        </a>
                                        <p class="text-xs text-gray-500 line-clamp-1 max-w-sm" x-html="product.description"></p>
                                        <span class="text-primary-600 font-bold mt-1" x-text="'$' + product.price"></span>
                                    </div>
                                </div>
                                <button
                                    class="bg-primary-600 text-white px-3 py-2 rounded-lg hover:bg-primary-700 transition-colors duration-150 shadow-sm hidden items-center gap-1 whitespace-nowrap"
                                    @click="addToCart()"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 90 90" fill="currentColor">
                                        <path d="M72.975 58.994H31.855c-1.539 0-2.897-1.005-3.347-2.477L15.199 13.006H3.5c-1.933 0-3.5-1.567-3.5-3.5s1.567-3.5 3.5-3.5h14.289c1.539 0 2.897 1.005 3.347 2.476l13.309 43.512h36.204l10.585-25.191h-6.021c-1.933 0-3.5-1.567-3.5-3.5s1.567-3.5 3.5-3.5H86.5c1.172 0 2.267 0.587 2.915 1.563s0.766 2.212 0.312 3.293L76.201 56.85C75.655 58.149 74.384 58.994 72.975 58.994z" />
                                        <circle cx="28.88" cy="74.33" r="6.16" />
                                        <circle cx="74.59" cy="74.33" r="6.16" />
                                    </svg>
                                    <span class="hidden sm:inline">Add to Cart</span>
                                </button>
                            </div>
                        </li>
                    </template>
                </ul>
            </div>
        </form>
        <div>

            <div class="flex items-center gap-4">


                <!-- Live Search Wrapper -->
                <div x-data="{ isOpen: false }" class="sm:hidden">
                    <!-- Search Button -->
                    <button @click="isOpen = !isOpen" class="text-gray-900 hover:text-primary-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>

                    <!-- Search Bar (Overlapping) -->
                    <div x-data="liveSearchComponent()"
                         x-show="isOpen"
                         @click.outside="isOpen = false"
                         x-transition:enter="transition-opacity transition-transform ease-out duration-200 scale-95"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition-opacity ease-in duration-150"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="absolute bg-white shadow-lg rounded-lg
            w-[90vw] left-1/2 transform -translate-x-1/2 top-full mt-2"
                         x-cloak
                    >


                    <!-- Search Input -->
                        <div class="flex items-center space-between w-full rounded-lg border border-gray-100 shadow-md focus-within:outline-none focus-within:ring focus-within:border-2 focus-within:border-primary-500">
                            <div class="px-5 text-gray-700 hover:text-primary-500 focus:outline-none focus:text-primary-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        <input
                            type="text"
                            x-model="searchTerm"
                            @input.debounce.300ms="fetchResults"
                            @focus="showDropdown = true"
                            @click.away="showDropdown = false ; searchTerm = ''"
                            class="py-5 w-full text-xl text-left text-black rounded-lg border-none focus:outline-none focus:ring-0 focus:border-transparent" placeholder="Rechercher..."
                        />
                            <button @click="searchTerm = ''" class="px-5 text-gray-700 hover:text-primary-500 focus:outline-none focus:text-primary-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Dropdown Results -->
                        <template x-if="showDropdown && results.length > 0">
                            <div
                                class="mt-2 w-full bg-white border border-gray-100 rounded-lg shadow-lg overflow-hidden"
                                @click.stop
                            >
                                <ul class="max-h-96 overflow-y-auto">
                                    <template x-for="product in results" :key="product.id">
                                        <li
                                            x-data="productItem({
                        id: product.id,
                        slug: product.slug,
                        title: product.title,
                        description: product.description,
                        price: product.price,
                        image: product.image_url || product.image || '/img/noimage.png',
                        addToCartUrl: `/cart/add/${product.slug}`
                    })"
                                            class="border-b border-gray-100 last:border-b-0 hover:bg-gray-50 transition-colors duration-150"
                                        >
                                            <div class="p-4 flex items-center justify-between">
                                                <div class="flex items-center gap-3 max-w-[70%]">
                                                    <a :href="`/products/${product.slug}`">
                                                        <img
                                                            class="w-16 h-16 min-w-16 object-cover rounded-md border border-gray-200 shadow-sm hover:scale-105 transition-transform"
                                                            :src="product.image"
                                                            alt="Product"
                                                        />
                                                    </a>
                                                    <div class="flex flex-col overflow-hidden">
                                                        <a :href="`/products/${product.slug}`" class="font-medium text-gray-800 hover:text-purple-600 transition-colors truncate">
                                                            <span x-text="product.title"></span>
                                                        </a>
                                                        <p class="text-xs text-gray-500 line-clamp-1 max-w-sm" x-html="product.description"></p>
                                                        <span class="text-purple-600 font-bold mt-1" x-text="'$' + product.price"></span>
                                                    </div>
                                                </div>
                                                <button
                                                    class="bg-purple-600 text-white px-3 py-2 rounded-lg hover:bg-purple-700 transition-colors duration-150 shadow-sm hidden items-center gap-1 whitespace-nowrap"
                                                    @click="addToCart()"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 90 90" fill="currentColor">
                                                        <path d="M72.975 58.994H31.855c-1.539 0-2.897-1.005-3.347-2.477L15.199 13.006H3.5c-1.933 0-3.5-1.567-3.5-3.5s1.567-3.5 3.5-3.5h14.289c1.539 0 2.897 1.005 3.347 2.476l13.309 43.512h36.204l10.585-25.191h-6.021c-1.933 0-3.5-1.567-3.5-3.5s1.567-3.5 3.5-3.5H86.5c1.172 0 2.267 0.587 2.915 1.563s0.766 2.212 0.312 3.293L76.201 56.85C75.655 58.149 74.384 58.994 72.975 58.994z" />
                                                        <circle cx="28.88" cy="74.33" r="6.16" />
                                                        <circle cx="74.59" cy="74.33" r="6.16" />
                                                    </svg>
                                                    <span class="hidden sm:inline">Add to Cart</span>
                                                </button>
                                            </div>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </template>
                    </div>
                </div>
                <!--  toggle cart menu -->
                <div class="">
                    <button x-data @click="$dispatch('cart-sidebar:open')" class="relative inline-block hover:text-primary-500">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1">
                            </circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                        <small
                            x-show="cartItemsCount"
                            x-transition
                            x-text="cartItemsCount"
                            x-cloak
                            class="absolute -top-2 -right-2 inline-flex items-center justify-center min-w-[20px] h-[20px] py-[2px] px-[5px] text-xs font-bold text-white rounded-full bg-primary-600"></small>
                    </button>
                </div>
                <div x-data="{ open: false }" class="relative inline-block text-left">
                    <div>
                        @if (!Auth::guest())
                            <!-- Logged-in user: toggle dropdown -->
                            <button @click="open = !open" type="button" class="relative inline-flex items-center justify-center text-gray-900 hover:text-primary-500 mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     width="36" height="36" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </button>
                        @else
                            <!-- Guest user: redirect to login when clicking the icon -->
                            <a href="{{ route('login') }}" class="relative inline-flex items-center justify-center text-gray-900 hover:text-primary-500 mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     width="36" height="36" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </a>
                        @endif
                    </div>

                    @if (!Auth::guest())
                        <!-- Dropdown menu (only for logged-in users) -->
                        <div x-show="open" @click.outside="open = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                             role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                            <div class="py-1" role="none">
                                <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1">Paramètre</a>
                                <a href="/orders" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1">Historique</a>
                                <form action="{{ route('logout') }}" method="post">
                                    @csrf
                                    <button type="submit" class="block w-full px-4 py-2 text-left text-sm text-gray-700">Sign out</button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>


            </div>
        </div>

    </header>
    <x-category-list :category-list="$categoryList" class="hide-under-810 md:flex" />




</main>


