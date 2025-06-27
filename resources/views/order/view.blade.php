<x-app-layout>
    <div class="container mx-auto lg:w-3/4 p-4 lg:p-6 mt-16 lg:mt-24">
        @php
            $username = $order->user->name ?? 'Christine';
            $customer = $order->user->customer;
            $address = null;
            if ($customer) {
                $shipping = $customer->shippingAddress;
                $billing  = $customer->billingAddress;
                $address = $shipping ? $shipping : ($billing ? $billing : null);
            }
            $address1 = $address ? $address->address1 : 'Adresse non spécifiée';
            $city     = $address ? $address->city : '';
            $zipcode  = $address ? $address->zipcode : '';
            $country  = $address && $address->country ? $address->country->name : ($address ? $address->country_code : '');
$items = $order->items()->with('product.sizes')->get()->filter(function ($item) {
    return $item->product !== null;
});            // Regrouper les items par taille (nom de la taille ou 'Sans taille')
            $groupedItems = $items->groupBy(function($item) {
                $sId = $item->size_id;
                $product = $item->product;

                if (!$product || !$product->sizes) {
                    return 'Sans taille';
                }

                $pivotSize = $product->sizes->firstWhere('id', $sId);
                return $pivotSize ? $pivotSize->name : 'Sans taille';
            });
        @endphp

        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <a href="{{ route('order.index') }}" class="text-secondary-700 hover:text-secondary-800 font-medium flex items-center mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span class="w-2"></span>
                Retour
            </a>
            <!-- Header -->
            <div class="bg-gray-50 p-6 border-b border-gray-200">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                    Détails de la Commande <span class="text-secondary-600">#{{ $order->id }}</span>
                </h1>
                <p class="text-gray-600 mt-1">{{ $username }}</p>
            </div>

            <!-- Order Summary -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm font-medium text-gray-700">Date de Commande</p>
                        <p class="text-gray-800 font-semibold">{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i') }}</p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm font-medium text-gray-700">Statut</p>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ !$order->isUnpaid() ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $order->status }}
                        </span>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm font-medium text-gray-700">Adresse de Livraison</p>
                        <p class="text-gray-800 font-normal truncate">{{ $address1 }}</p>
                        <p class="text-gray-800 font-normal truncate">{{ $city }} {{$zipcode}}, {{ $country }} </p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm font-medium text-gray-700">Total</p>
                        <p class="text-gray-800 font-bold">€{{ $order->total_price }}</p>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="px-6 pb-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Articles Commandés</h2>
                    <span class="text-sm font-medium px-3 py-1 bg-gray-100 text-gray-600 rounded-full">Regroupé par taille</span>
                </div>

                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <!-- Size tabs -->
                    @if(count($groupedItems) > 1)
                        <div class="flex overflow-x-auto bg-gray-50 border-b border-gray-200">
                            @foreach($groupedItems as $sizeName => $itemsGroup)
                                <button onclick="showSizeGroup('{{ str_replace(' ', '', $sizeName) }}')"
                                        class="size-tab py-3 px-6 font-medium text-gray-600 hover:text-gray-900 focus:outline-none {{ $loop->first ? 'border-b-2 border-secondary-500 text-secondary-600' : '' }}"
                                        data-size="{{ str_replace(' ', '', $sizeName) }}">
                                    {{ $sizeName }}
                                </button>
                            @endforeach
                        </div>
                    @endif

                    <!-- Items by size -->
                    @foreach($groupedItems as $sizeName => $itemsGroup)
                        <div id="size-{{ str_replace(' ', '', $sizeName) }}" class="size-content {{ !$loop->first ? 'hidden' : '' }}">
                            @foreach($itemsGroup as $item)
                                <div class="flex flex-col md:flex-row items-center gap-4 p-4 {{ !$loop->last ? 'border-b border-gray-200' : '' }}">
                                    <a href="{{ route('products.view', $item->product) }}" class="w-24 h-24 flex-shrink-0 rounded-md overflow-hidden">
                                        <img src="{{ $item->product->image ?: '/img/noimage.png' }}" class="w-full h-full object-cover" alt="{{ $item->product->title }}"/>
                                    </a>

                                    <div class="flex-grow">
                                        <h3 class="text-lg font-medium text-gray-800">
                                            {{ $item->product->title }}
                                        </h3>
                                        <div class="mt-1 flex items-center text-sm text-gray-700">
                                            <span class="mr-2">Taille:</span>
                                            <span class="font-medium">{{ $sizeName }}</span>
                                        </div>
                                    </div>

                                    <div class="flex flex-col items-end ml-4">
                                        <div class="text-gray-600">
                                            <span>€{{ $item->unit_price }} × {{ $item->quantity }}</span>
                                        </div>
                                        <div class="mt-1 font-semibold text-gray-900">
                                            €{{ number_format($item->quantity * $item->unit_price, 2) }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Order Total & Actions -->
            <div class="border-t border-gray-200 px-6 py-4 bg-gray-50">
                <div class="flex justify-between items-center">
                    <span class="text-lg font-medium text-gray-700">Total</span>
                    <span class="text-2xl font-bold text-gray-900">€{{ $order->total_price }}</span>
                </div>

                @if ($order->isUnpaid())
                    <form action="{{ route('cart.checkout-order', $order) }}" method="POST" class="mt-4">
                        @csrf
                        <button type="submit" class="w-full py-3 text-white bg-secondary-600 rounded-lg shadow hover:bg-secondary-700 transition-colors text-lg font-semibold flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                            Procéder au Paiement
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <!-- JavaScript for size tabs -->
    <script>
        function showSizeGroup(sizeName) {
            // Hide all size contents
            document.querySelectorAll('.size-content').forEach(content => {
                content.classList.add('hidden');
            });

            // Show selected size content
            document.getElementById('size-' + sizeName).classList.remove('hidden');

            // Update active tab
            document.querySelectorAll('.size-tab').forEach(tab => {
                tab.classList.remove('border-b-2', 'border-secondary-500', 'text-secondary-600');
            });

            document.querySelector('[data-size="' + sizeName + '"]').classList.add('border-b-2', 'border-secondary-500', 'text-secondary-600');
        }
    </script>
</x-app-layout>
