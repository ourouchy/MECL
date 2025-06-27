<x-app-layout>
    <div class="container py-12">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-card overflow-hidden relative">
            <!-- Pet paw prints decoration - top -->
            <div class="absolute top-0 left-0 w-full h-6 overflow-hidden">
                <div class="flex justify-between px-2">
                    <svg class="h-6 w-6 text-secondary-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor"><path d="M226.5 92.9c14.3 42.9-.3 86.2-32.6 96.8s-70.1-15.6-84.4-58.5s.3-86.2 32.6-96.8s70.1 15.6 84.4 58.5zM100.4 198.6c18.9 32.4 14.3 70.1-10.2 84.1s-59.7-.9-78.5-33.3S-2.7 179.3 21.8 165.3s59.7 .9 78.5 33.3zM69.2 401.2C121.6 259.9 214.7 224 256 224s134.4 35.9 186.8 177.2c3.6 9.7 5.2 20.1 5.2 30.5v1.6c0 25.8-20.9 46.7-46.7 46.7c-11.5 0-22.9-1.4-34-4.2l-88-22c-15.3-3.8-31.3-3.8-46.6 0l-88 22c-11.1 2.8-22.5 4.2-34 4.2C84.9 480 64 459.1 64 433.3v-1.6c0-10.4 1.6-20.8 5.2-30.5zM421.8 282.7c-24.5-14-29.1-51.7-10.2-84.1s54-47.3 78.5-33.3s29.1 51.7 10.2 84.1s-54 47.3-78.5 33.3zM310.1 189.7c-32.3-10.6-46.9-53.9-32.6-96.8s52.1-69.1 84.4-58.5s46.9 53.9 32.6 96.8s-52.1 69.1-84.4 58.5z"/></svg>
                    <svg class="h-6 w-6 text-secondary-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor"><path d="M226.5 92.9c14.3 42.9-.3 86.2-32.6 96.8s-70.1-15.6-84.4-58.5s.3-86.2 32.6-96.8s70.1 15.6 84.4 58.5zM100.4 198.6c18.9 32.4 14.3 70.1-10.2 84.1s-59.7-.9-78.5-33.3S-2.7 179.3 21.8 165.3s59.7 .9 78.5 33.3zM69.2 401.2C121.6 259.9 214.7 224 256 224s134.4 35.9 186.8 177.2c3.6 9.7 5.2 20.1 5.2 30.5v1.6c0 25.8-20.9 46.7-46.7 46.7c-11.5 0-22.9-1.4-34-4.2l-88-22c-15.3-3.8-31.3-3.8-46.6 0l-88 22c-11.1 2.8-22.5 4.2-34 4.2C84.9 480 64 459.1 64 433.3v-1.6c0-10.4 1.6-20.8 5.2-30.5zM421.8 282.7c-24.5-14-29.1-51.7-10.2-84.1s54-47.3 78.5-33.3s29.1 51.7 10.2 84.1s-54 47.3-78.5 33.3zM310.1 189.7c-32.3-10.6-46.9-53.9-32.6-96.8s52.1-69.1 84.4-58.5s46.9 53.9 32.6 96.8s-52.1 69.1-84.4 58.5z"/></svg>
                    <svg class="h-6 w-6 text-secondary-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor"><path d="M226.5 92.9c14.3 42.9-.3 86.2-32.6 96.8s-70.1-15.6-84.4-58.5s.3-86.2 32.6-96.8s70.1 15.6 84.4 58.5zM100.4 198.6c18.9 32.4 14.3 70.1-10.2 84.1s-59.7-.9-78.5-33.3S-2.7 179.3 21.8 165.3s59.7 .9 78.5 33.3zM69.2 401.2C121.6 259.9 214.7 224 256 224s134.4 35.9 186.8 177.2c3.6 9.7 5.2 20.1 5.2 30.5v1.6c0 25.8-20.9 46.7-46.7 46.7c-11.5 0-22.9-1.4-34-4.2l-88-22c-15.3-3.8-31.3-3.8-46.6 0l-88 22c-11.1 2.8-22.5 4.2-34 4.2C84.9 480 64 459.1 64 433.3v-1.6c0-10.4 1.6-20.8 5.2-30.5zM421.8 282.7c-24.5-14-29.1-51.7-10.2-84.1s54-47.3 78.5-33.3s29.1 51.7 10.2 84.1s-54 47.3-78.5 33.3zM310.1 189.7c-32.3-10.6-46.9-53.9-32.6-96.8s52.1-69.1 84.4-58.5s46.9 53.9 32.6 96.8s-52.1 69.1-84.4 58.5z"/></svg>
                </div>
            </div>

            <!-- Success header with gradient -->
            <div class="bg-gradient-to-r from-primary-500 to-secondary-500 py-4 px-6">
                <h2 class="text-xl font-semibold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Pawsome! Order Successful
                </h2>
            </div>

            <!-- Success content -->
            <div class="p-6">
                <!-- Happy pet image -->
                <div class="flex justify-center mb-4">
                    <div class="w-24 h-24 rounded-full bg-secondary-100 flex items-center justify-center">
                        <svg width="80px" height="80px" viewBox="0 0 48 48" id="a" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <style>.b{fill:none;stroke:#A2550C;stroke-linecap:round;stroke-linejoin:round;}</style>
                            </defs>
                            <path class="b" d="M26.1227,43.5c.5641-15.2541-5.5775-20.398-10.4257-23.5907,1.1825-5.7942,5.4274-8.9252,5.4274-8.9252"/>
                            <path class="b" d="M25.0978,10.3312s-1.9733,3.1927-3.747,3.2592c0,0-.5765-5.8312-.3547-7.0063,1.4412-1.685,4.5452-2.0841,6.3189-2.0841s3.1927,1.1973,3.4366,3.8135c1.685,.0222,3.2814,.7982,3.614,1.5298-.1109,1.8624-1.6185,2.8158-3.0819,3.3701s-2.6606,1.4633-2.6606,2.3502,.3991,4.2348,2.8823,4.7004,6.4076,1.685,6.4076,5.6981-1.3525,3.3479-1.3525,7.2797,.4139,3.0449,.4139,5.0551-.6504,3.784-1.3007,4.9665"/><path class="b" d="M32.3332,42.9088s.7391-3.4292,.7391-5.0551-1.3816-3.7392-2.838-5.5725c-1.2564-1.5816-4.5337-.2037-4.4144,3.9035"/>
                            <path class="b" d="M36.1235,22.1417c3.3046,.3395,5.6105-2.5576,3.6593-6.0459"/>
                            <path class="b" d="M15.697,19.9093c.2069,.9164,.3769,2.7493,.3769,2.7493-1.1314,0-2.1587,.9578-2.8017,1.3791-1.312,.8596-2.6858,1.1485-2.6378,2.7005,.473,1.2416,2.5941,1.382,4.1313,1.3525l-.0333,.8647c-1.5314,1.4637-4.4233,4.7455-4.4233,8.78,0,4.7004,3.4366,5.5281,5.3877,5.5281s11.6804-4.9184,8.4888-13.5099"/>
                            <path class="b" d="M7.7078,30.1379c.9164,.0887,1.9215,.2365,1.9215,1.685s-2.1285,2.8084-2.1285,6.2081,2.2837,5.2325,8.1961,5.2325"/>
                            <path class="b" d="M36.8827,37.0506c-.5586-2.1828-3.101-4.5774-3.8105-4.9321s-.7506,3.236-.2349,4.4486"/>
                        </svg>
                    </div>
                </div>

                <div class="mb-6 bg-primary-50 p-4 rounded-lg border border-primary-100">
                    <p class="text-neutral-800 font-medium text-center">
                        Thank you <span class="font-bold">{{ $customer->name }}</span>! Your furry friends' goodies are on the way!
                    </p>
                </div>

                <!-- Order details summary with paw accent -->
                <div class="mb-6 relative">
                    <div class="absolute -left-2 top-3">
                        <svg class="h-5 w-5 text-secondary-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor"><path d="M226.5 92.9c14.3 42.9-.3 86.2-32.6 96.8s-70.1-15.6-84.4-58.5s.3-86.2 32.6-96.8s70.1 15.6 84.4 58.5zM100.4 198.6c18.9 32.4 14.3 70.1-10.2 84.1s-59.7-.9-78.5-33.3S-2.7 179.3 21.8 165.3s59.7 .9 78.5 33.3zM69.2 401.2C121.6 259.9 214.7 224 256 224s134.4 35.9 186.8 177.2c3.6 9.7 5.2 20.1 5.2 30.5v1.6c0 25.8-20.9 46.7-46.7 46.7c-11.5 0-22.9-1.4-34-4.2l-88-22c-15.3-3.8-31.3-3.8-46.6 0l-88 22c-11.1 2.8-22.5 4.2-34 4.2C84.9 480 64 459.1 64 433.3v-1.6c0-10.4 1.6-20.8 5.2-30.5zM421.8 282.7c-24.5-14-29.1-51.7-10.2-84.1s54-47.3 78.5-33.3s29.1 51.7 10.2 84.1s-54 47.3-78.5 33.3zM310.1 189.7c-32.3-10.6-46.9-53.9-32.6-96.8s52.1-69.1 84.4-58.5s46.9 53.9 32.6 96.8s-52.1 69.1-84.4 58.5z"/></svg>
                    </div>
                    <h3 class="text-neutral-800 font-semibold mb-3 pl-4">Order Details</h3>
                    <div class="bg-gray-200 rounded p-4 border-l-4 border-secondary-400">
                        <p class="text-sm text-neutral-700 mb-2">
                            <span class="font-medium">Order ID:</span> #{{ $order->id }}
                        </p>
                        <p class="text-sm text-neutral-700 mb-2">
                            <span class="font-medium">Total Price:</span> ${{ number_format($order->total_price, 2) }}
                        </p>
                        <p class="text-sm text-neutral-700 mb-2">
                            <span class="font-medium">Date:</span> {{ $order->created_at->format('F j, Y') }}
                        </p>
                        <p class="text-sm text-neutral-700">
                            <span class="font-medium">Estimated Delivery:</span> {{ now()->addDays(5)->format('F j, Y') }}
                        </p>
                    </div>
                </div>

                <!-- Pet quote -->
                <div class="mb-6 py-3 px-4 bg-secondary-50 rounded-lg border border-secondary-100 italic text-center text-sm text-neutral-700">
                    "Tails are wagging with excitement for your delivery!"
                </div>

                <!-- Action buttons -->
                <div class="flex flex-col space-y-3 sm:flex-row sm:space-y-0 sm:space-x-3">
                    <a href="{{ route('home') }}" class="inline-block bg-primary-500 hover:bg-primary-600 text-white text-center py-2 px-4 rounded transition-colors duration-200 flex-1 flex items-center justify-center">
                        <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" fill="currentColor"><path d="M575.8 255.5c0 18-15 32.1-32 32.1h-32l.7 160.2c0 2.7-.2 5.4-.5 8.1V472c0 22.1-17.9 40-40 40H456c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1H416 392c-22.1 0-40-17.9-40-40V448 384c0-17.7-14.3-32-32-32H256c-17.7 0-32 14.3-32 32v64 24c0 22.1-17.9 40-40 40H160 128.1c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2H104c-22.1 0-40-17.9-40-40V360c0-.9 0-1.9 .1-2.8V287.6H32c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z"/></svg>
                        Back to Shop
                    </a>
                    <a href="{{ route('order.view', $order) }}" class="inline-block bg-secondary-500 hover:bg-secondary-600 text-white text-center py-2 px-4 rounded transition-colors duration-200 flex-1 flex items-center justify-center">
                        <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor"><path d="M64 144a48 48 0 1 0 0-96 48 48 0 1 0 0 96zM192 64c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zM64 464a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm48-208a48 48 0 1 0 -96 0 48 48 0 1 0 96 0z"/></svg>
                        View Order Details
                    </a>
                </div>
            </div>

            <!-- Pet paw prints decoration - bottom -->
            <div class="bg-gray-100 py-3 px-6 border-t border-gray-200">
                <div class="flex justify-center gap-6">
                    <svg class="h-5 w-5 text-secondary-400 transform rotate-12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor"><path d="M226.5 92.9c14.3 42.9-.3 86.2-32.6 96.8s-70.1-15.6-84.4-58.5s.3-86.2 32.6-96.8s70.1 15.6 84.4 58.5zM100.4 198.6c18.9 32.4 14.3 70.1-10.2 84.1s-59.7-.9-78.5-33.3S-2.7 179.3 21.8 165.3s59.7 .9 78.5 33.3zM69.2 401.2C121.6 259.9 214.7 224 256 224s134.4 35.9 186.8 177.2c3.6 9.7 5.2 20.1 5.2 30.5v1.6c0 25.8-20.9 46.7-46.7 46.7c-11.5 0-22.9-1.4-34-4.2l-88-22c-15.3-3.8-31.3-3.8-46.6 0l-88 22c-11.1 2.8-22.5 4.2-34 4.2C84.9 480 64 459.1 64 433.3v-1.6c0-10.4 1.6-20.8 5.2-30.5zM421.8 282.7c-24.5-14-29.1-51.7-10.2-84.1s54-47.3 78.5-33.3s29.1 51.7 10.2 84.1s-54 47.3-78.5 33.3zM310.1 189.7c-32.3-10.6-46.9-53.9-32.6-96.8s52.1-69.1 84.4-58.5s46.9 53.9 32.6 96.8s-52.1 69.1-84.4 58.5z"/></svg>
                    <svg class="h-5 w-5 text-secondary-400 transform -rotate-12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor"><path d="M226.5 92.9c14.3 42.9-.3 86.2-32.6 96.8s-70.1-15.6-84.4-58.5s.3-86.2 32.6-96.8s70.1 15.6 84.4 58.5zM100.4 198.6c18.9 32.4 14.3 70.1-10.2 84.1s-59.7-.9-78.5-33.3S-2.7 179.3 21.8 165.3s59.7 .9 78.5 33.3zM69.2 401.2C121.6 259.9 214.7 224 256 224s134.4 35.9 186.8 177.2c3.6 9.7 5.2 20.1 5.2 30.5v1.6c0 25.8-20.9 46.7-46.7 46.7c-11.5 0-22.9-1.4-34-4.2l-88-22c-15.3-3.8-31.3-3.8-46.6 0l-88 22c-11.1 2.8-22.5 4.2-34 4.2C84.9 480 64 459.1 64 433.3v-1.6c0-10.4 1.6-20.8 5.2-30.5zM421.8 282.7c-24.5-14-29.1-51.7-10.2-84.1s54-47.3 78.5-33.3s29.1 51.7 10.2 84.1s-54 47.3-78.5 33.3zM310.1 189.7c-32.3-10.6-46.9-53.9-32.6-96.8s52.1-69.1 84.4-58.5s46.9 53.9 32.6 96.8s-52.1 69.1-84.4 58.5z"/></svg>
                    <svg class="h-5 w-5 text-secondary-400 transform rotate-45" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor"><path d="M226.5 92.9c14.3 42.9-.3 86.2-32.6 96.8s-70.1-15.6-84.4-58.5s.3-86.2 32.6-96.8s70.1 15.6 84.4 58.5zM100.4 198.6c18.9 32.4 14.3 70.1-10.2 84.1s-59.7-.9-78.5-33.3S-2.7 179.3 21.8 165.3s59.7 .9 78.5 33.3zM69.2 401.2C121.6 259.9 214.7 224 256 224s134.4 35.9 186.8 177.2c3.6 9.7 5.2 20.1 5.2 30.5v1.6c0 25.8-20.9 46.7-46.7 46.7c-11.5 0-22.9-1.4-34-4.2l-88-22c-15.3-3.8-31.3-3.8-46.6 0l-88 22c-11.1 2.8-22.5 4.2-34 4.2C84.9 480 64 459.1 64 433.3v-1.6c0-10.4 1.6-20.8 5.2-30.5zM421.8 282.7c-24.5-14-29.1-51.7-10.2-84.1s54-47.3 78.5-33.3s29.1 51.7 10.2 84.1s-54 47.3-78.5 33.3zM310.1 189.7c-32.3-10.6-46.9-53.9-32.6-96.8s52.1-69.1 84.4-58.5s46.9 53.9 32.6 96.8s-52.1 69.1-84.4 58.5z"/></svg>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
