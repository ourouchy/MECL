<x-app-layout>
    <div class="container mx-auto mt-8 px-4 max-w-8xl">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl md:text-3xl font-bold text-neutral-800">Panier</h1>
            <a href="{{ route('products.index') }}" class="text-secondary-500 hover:text-secondary-600 font-medium flex items-center">
                Rajoutez au panier
                <span class="w-2"></span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="transform: scaleX(-1);">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
        </div>

        <div
            x-data="{
                cartItems: {{
                    json_encode(
                        collect(array_values($cartItems))->map(function($line) use ($products) {
                            $pId = $line['product_id'];
                            $sId = $line['size_id'] ?? null;
                            $qty = $line['quantity'] ?? 1;
                            $product = $products->firstWhere('id', $pId);
                            if (!$product) return null;
                            $pivotSize = $product->sizes->firstWhere('id', $sId);
                            $sizeName  = $pivotSize ? $pivotSize->name : null;
                            $unitPrice = $product->getPriceBySize($sId);
                            $maxStock  = $sId ? ($pivotSize ? $pivotSize->pivot->stock : 0) : ($product->quantity ?? 0);
                            return [
                                'id' => $pId . '_' . ($sId ?? 'no'),
                                'product_id' => $pId,
                                'size_id' => $sId,
                                'quantity' => $qty,
                                'max_stock' => $maxStock,
                                'size_name' => $sizeName,
                                'title' => $product->title,
                                'image' => $product->image ?: '/img/noimage.png',
                                'price' => $unitPrice,
                                'removeUrl' => route('cart.remove', $product),
                                'updateQuantityUrl' => route('cart.update-quantity', $product)
                            ];
                        })->filter()->values()
                    )
                }},
                get cartTotal() {
                    return this.cartItems.reduce((sum, product) => sum + product.price * product.quantity, 0).toFixed(2)
                },
                get isFreeShipping() {
                    return parseFloat(this.cartTotal) >= 49;
                },
                removeItem(productId) {
                    // Filter out the removed item and update the array
                    this.cartItems = this.cartItems.filter(item => item.id !== productId);
                }
            }"
            @cart-change.window="cartItems = cartItems.filter(p => p.id !== $event.detail.product_id)"
        >
            <template x-if="cartItems.length">
                <div class="flex flex-col lg:flex-row gap-8">
                    <!-- Cart Items -->
                    <div class="lg:w-2/3">
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-500">
                            <div class="hidden md:flex py-4 px-6 bg-gray-400 text-sm font-medium text-neutral-800 border-b">
                                <div class="w-1/2">Product</div>
                                <div class="w-1/6 text-center">Price</div>
                                <div class="w-1/6 text-center">Quantity</div>
                                <div class="w-1/6 text-right">Total</div>
                            </div>

                            <div class="divide-y divide-gray-500">
                                <template x-for="product in cartItems" :key="product.id">
                                    <div x-data="{
                                        product: product,
                                        removeItemFromCart() {
                                            fetch(product.removeUrl, {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                                                },
                                                body: JSON.stringify({
                                                    size_id: product.size_id
                                                })
                                            })
                                            .then(response => response.json())
                                            .then(data => {
                            window.dispatchEvent(new CustomEvent('cart-change', { detail: { product_id: product.id } }));
                                                    console.log('product'.id);

                                    });
                                        },
                                        changeQuantity() {
                                            fetch(product.updateQuantityUrl, {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                                                },
                                                body: JSON.stringify({
                                                    size_id: product.size_id,
                                                    quantity: product.quantity
                                                })
                                            })
                                            .then(response => response.json())
                                            .then(result => {
                                                // 👇 Dispatch the new cart count to update navbar
                                                window.dispatchEvent(new CustomEvent('cart-change', { detail: { count: result.count } }));
                                            });;
                                        }
                                    }" class="p-4 sm:p-6 hover:bg-gray-300 transition-colors duration-150">
                                        <div class="flex flex-col md:flex-row items-center">
                                            <a :href="product.href" class="w-20 h-20 flex-shrink-0 bg-gray-400 rounded-md border overflow-hidden">
                                                <img :src="product.image" alt="" class="w-full h-full object-cover object-center" />
                                            </a>
                                            <div class="ml-4 flex-1">
                                                <h3 x-text="product.title" class="text-neutral-800 font-medium"></h3>
                                                <template x-if="product.size_name">
                                                    <div class="text-sm text-neutral-700 mt-1">
                                                        Size: <span x-text="product.size_name" class="font-medium"></span>
                                                    </div>
                                                </template>
                                                <a href="#" @click.prevent="removeItemFromCart()" class="text-secondary-500 hover:text-secondary-600 text-sm font-medium inline-flex items-center mt-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                                    </svg>
                                                    Remove
                                                </a>
                                            </div>
                                            <div class="flex flex-col items-center md:items-end mt-4 md:mt-0 w-full md:w-1/6">
                                                <div class="text-sm font-medium text-neutral-700 mb-1 hidden md:block">Price</div>
                                                <span class="text-neutral-800">€<span x-text="parseFloat(product.price).toFixed(2)"></span></span>
                                            </div>
                                            <div class="flex flex-col items-center md:items-end mt-4 md:mt-0 w-full md:w-1/6">
                                                <div class="text-sm font-medium text-neutral-700 mb-1 hidden md:block">Quantity</div>
                                                <div class="inline-flex items-center border border-gray-600 rounded">
                                                    <button @click="product.quantity > 1 ? (product.quantity--, changeQuantity()) : null" class="px-2 py-0.5 text-neutral-700 hover:bg-gray-400">−</button>
                                                    <input type="number" min="1" x-model="product.quantity" @change="changeQuantity()" class="w-8 text-center border-0 focus:ring-0" />
                                                    <button @click="product.quantity < product.max_stock ? (product.quantity++, changeQuantity()) : null" class="px-2 py-0.5 text-neutral-700 hover:bg-gray-400">+</button>
                                                </div>
                                                <div class="text-xs text-neutral-600 mt-1" x-show="product.max_stock">Max: <span x-text="product.max_stock"></span></div>
                                            </div>
                                            <div class="flex flex-col items-center md:items-end mt-4 md:mt-0 w-full md:w-1/6">
                                                <div class="text-sm font-medium text-neutral-700 mb-1 hidden md:block">Total</div>
                                                <span class="text-neutral-800 font-medium">€<span x-text="(product.price * product.quantity).toFixed(2)"></span></span>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:w-1/3">
                        <div class="bg-white rounded-lg shadow-sm border border-gray-500 p-6 sticky top-6">
                            <h2 class="text-lg font-semibold text-neutral-800 mb-6">Order Summary</h2>
                            <div class="space-y-4">
                                <div class="flex justify-between">
                                    <span class="text-neutral-700">Subtotal</span>
                                    <span class="text-neutral-800 font-medium">€<span x-text="cartTotal"></span></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-neutral-700">Shipping</span>
                                    <span class="text-neutral-800">
        <span x-show="isFreeShipping">Free Shipping</span>
        <span x-show="!isFreeShipping">Calculated at checkout</span>
    </span>
                                </div>
                                <div class="border-t border-gray-500 pt-4 mt-2">
                                    <div class="flex justify-between font-semibold">
                                        <span>Estimated Total</span>
                                        <span class="text-neutral-800">
                                            €<span x-show="isFreeShipping" x-text="(cartTotal)"></span>
                                             <span x-show="!isFreeShipping" x-text="(parseFloat(cartTotal) + 6).toFixed(2)"></span>
                                            </span>
                                    </div>
                                </div>
                            </div>
                            <form action="{{ route('cart.checkout') }}" method="post" class="mt-6">
                                @csrf
                                @guest
                                    <div class="mb-4">
                                        <label for="guest_email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                        <input type="email" id="guest_email" name="email" required
                                               class="w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500"
                                               placeholder="Enter your email" />
                                    </div>

                                    <div class="mb-4">
                                        <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                                        <input type="text" id="first_name" name="first_name" required
                                               class="w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500"
                                               placeholder="First Name" />
                                    </div>

                                    <div class="mb-4">
                                        <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                                        <input type="text" id="last_name" name="last_name" required
                                               class="w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500"
                                               placeholder="Last Name" />
                                    </div>

                                    <div class="mb-4">
                                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                        <input type="text" id="phone" name="phone" required
                                               class="w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500"
                                               placeholder="Phone Number" />
                                    </div>

                                    <div class="mb-4">
                                        <label for="address1" class="block text-sm font-medium text-gray-700 mb-1">Address Line 1</label>
                                        <input type="text" id="address1" name="address1" required
                                               class="w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500"
                                               placeholder="Street address" />
                                    </div>

                                    <div class="mb-4">
                                        <label for="address2" class="block text-sm font-medium text-gray-700 mb-1">Address Line 2 (optional)</label>
                                        <input type="text" id="address2" name="address2"
                                               class="w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500"
                                               placeholder="Apartment, suite, etc." />
                                    </div>

                                    <div class="mb-4">
                                        <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                                        <input type="text" id="city" name="city" required
                                               class="w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500"
                                               placeholder="City" />
                                    </div>

                                    <div class="mb-4">
                                        <label for="state" class="block text-sm font-medium text-gray-700 mb-1">State (optional)</label>
                                        <input type="text" id="state" name="state"
                                               class="w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500"
                                               placeholder="State" />
                                    </div>

                                    <div class="mb-4">
                                        <label for="country" class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                                        <input type="text" id="country" name="country" required
                                               class="w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500"
                                               placeholder="Country" />
                                    </div>

                                    <div class="mb-4">
                                        <label for="zipcode" class="block text-sm font-medium text-gray-700 mb-1">Postal / Zip Code</label>
                                        <input type="text" id="zipcode" name="zipcode" required
                                               class="w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500"
                                               placeholder="Postal Code" />
                                    </div>
                                @endguest
                                <button type="submit" class="w-full bg-primary-500 hover:bg-primary-600 text-white font-medium py-3 px-4 rounded-md transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                                    Proceed to Checkout
                                </button>
                            </form>
                            <p class="text-sm text-neutral-500 mt-4 text-center">Secure checkout powered by Stripe</p>

                            <!-- New Customer Promo Banner -->
                            <div class="mt-6 p-4 bg-secondary-100 rounded-lg">
                                <div class="font-medium text-secondary-700">New Customer?</div>
                                <p class="text-sm text-secondary-700 mt-1">Save 20% on your first order when you sign up for our newsletter!</p>
                                <a href="#" class="text-sm font-medium text-secondary-600 hover:text-secondary-700 mt-2 inline-block">
                                    Learn More
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            <template x-if="!cartItems.length">
                <div class="bg-white rounded-lg shadow-sm p-8 text-center">
                    <div class="w-16 h-16 mx-auto mb-4 flex items-center justify-center bg-secondary-100 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-secondary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h2 class="text-lg font-medium text-neutral-800 mb-2">Your cart is empty</h2>
                    <p class="text-neutral-700 mb-6">Looks like you haven't added any pet products to your cart yet.</p>
                    <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center px-6 py-3 bg-primary-500 hover:bg-primary-600 text-white font-medium rounded-md transition-colors">
                        Start Shopping
                    </a>
                </div>
            </template>
        </div>

        <!-- Pet-Friendly Recommendations -->
        @if($recommendedProducts->count())
            <section class="mt-12 mb-8">
                <h2 class="text-xl font-bold text-neutral-800 mb-6">Recommended For Your Pets</h2>

                <div class="overflow-x-auto scrollbar-hide">
                    <div class="flex gap-6 min-w-full">
                        @foreach($recommendedProducts as $product)
                            <div class="w-64 flex-shrink-0">
                                <x-landing.product-card-preview :product="$product" />
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

    </div>
</x-app-layout>
