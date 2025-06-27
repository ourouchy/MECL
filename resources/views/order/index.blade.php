<x-app-layout>
    <div class="container mx-auto lg:w-2/3 p-5">
        <h1 class="text-3xl font-bold mb-2">My Orders</h1>

        <div class="bg-white rounded-lg p-3 overflow-x-auto mt-28">
            @foreach($orders as $order)
                {{-- Chaque commande en "row" avec la nouvelle UI --}}

                <div class="flex flex-wrap items-center gap-y-4 py-6 border-b">
                    {{-- Order ID --}}
                    <dl class="w-1/2 sm:w-1/4 lg:w-auto lg:flex-1">
                        <dt class="text-base font-medium text-gray-700 dark:text-gray-400">Order ID:</dt>
                        <dd class="mt-1.5 text-base font-semibold text-gray-900 dark:text-white">
                            <a
                                href="{{ route('order.view', $order) }}"
                                class="hover:underline"
                            >
                                #{{ $order->id }}
                            </a>
                        </dd>
                    </dl>

                    {{-- Date --}}
                    <dl class="w-1/2 sm:w-1/4 lg:w-auto lg:flex-1">
                        <dt class="text-base font-medium text-gray-700 dark:text-gray-400">Date:</dt>
                        <dd class="mt-1.5 text-base font-semibold text-gray-900 dark:text-white">
                            {{ $order->created_at->format('d.m.Y') }}
                        </dd>
                    </dl>

                    {{-- Price --}}
                    <dl class="w-1/2 sm:w-1/4 lg:w-auto lg:flex-1">
                        <dt class="text-base font-medium text-gray-700 dark:text-gray-400">Price:</dt>
                        <dd class="mt-1.5 text-base font-semibold text-gray-900 dark:text-white">
                            €{{ $order->total_price }}
                        </dd>
                    </dl>

                    {{-- Status (Pending, Paid/Confirmed, Unpaid/Cancelled) --}}
                    @php
                        $status = strtolower($order->status);
                    @endphp

                    <dl class="w-1/2 sm:w-1/4 lg:w-auto lg:flex-1">
                        <dt class="text-base font-medium text-gray-700 dark:text-gray-400">Status:</dt>

                        @switch($status)
                            @case('paid')
                                <dd class="me-2 mt-1.5 inline-flex items-center rounded bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-300">
                                    Paid
                                </dd>
                                @break

                            @case('unpaid')
                                <dd class="me-2 mt-1.5 inline-flex items-center rounded bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                                    Unpaid
                                </dd>
                                @break

                            @case('cancelled')
                                <dd class="me-2 mt-1.5 inline-flex items-center rounded bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800 dark:bg-red-900 dark:text-red-300">
                                    Cancelled
                                </dd>
                                @break

                            @case('shipped')
                                <dd class="me-2 mt-1.5 inline-flex items-center rounded bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                    Shipped
                                </dd>
                                @break

                            @case('completed')
                                <dd class="me-2 mt-1.5 inline-flex items-center rounded bg-purple-100 px-2.5 py-0.5 text-xs font-medium text-purple-800 dark:bg-purple-900 dark:text-purple-300">
                                    Completed
                                </dd>
                                @break

                            @default
                                <dd class="me-2 mt-1.5 inline-flex items-center rounded bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800 dark:bg-gray-900 dark:text-gray-300">
                                    {{ ucfirst($status) }}
                                </dd>
                        @endswitch
                    </dl>

                    {{-- Actions (Pay if not paid, View details, etc.) --}}
                    <div class="w-full grid sm:grid-cols-2 lg:flex lg:w-64 lg:items-center lg:justify-end gap-4">
                        @if ($order->isUnpaid())
                            <form
                                action="{{ route('cart.checkout-order', $order) }}"
                                method="POST"
                            >
                                @csrf

                                <button
                                    class="w-full lg:w-auto rounded-lg border border-red-700 px-3 py-2 text-center text-sm font-medium text-red-700 hover:bg-red-700 hover:text-white focus:outline-none focus:ring-4 focus:ring-red-300 dark:border-red-500 dark:text-red-500 dark:hover:bg-red-600 dark:hover:text-white dark:focus:ring-red-900"
                                >
                                    Pay
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('order.view', $order) }}"
                           class="w-full inline-flex justify-center rounded-lg border border-gray-500 bg-white px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700 lg:w-auto"
                        >
                            View details
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-3">
            {{ $orders->links() }}
        </div>
    </div>
</x-app-layout>
