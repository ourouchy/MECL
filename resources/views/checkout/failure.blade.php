<x-app-layout>
    <div class="container py-12">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-card overflow-hidden relative">
            <!-- Subtle paw print decoration - muted -->
            <div class="absolute top-0 left-0 w-full h-6 overflow-hidden opacity-30">
                <div class="flex justify-between px-2">
                    <svg class="h-6 w-6 text-neutral-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor"><path d="M226.5 92.9c14.3 42.9-.3 86.2-32.6 96.8s-70.1-15.6-84.4-58.5s.3-86.2 32.6-96.8s70.1 15.6 84.4 58.5zM100.4 198.6c18.9 32.4 14.3 70.1-10.2 84.1s-59.7-.9-78.5-33.3S-2.7 179.3 21.8 165.3s59.7 .9 78.5 33.3zM69.2 401.2C121.6 259.9 214.7 224 256 224s134.4 35.9 186.8 177.2c3.6 9.7 5.2 20.1 5.2 30.5v1.6c0 25.8-20.9 46.7-46.7 46.7c-11.5 0-22.9-1.4-34-4.2l-88-22c-15.3-3.8-31.3-3.8-46.6 0l-88 22c-11.1 2.8-22.5 4.2-34 4.2C84.9 480 64 459.1 64 433.3v-1.6c0-10.4 1.6-20.8 5.2-30.5zM421.8 282.7c-24.5-14-29.1-51.7-10.2-84.1s54-47.3 78.5-33.3s29.1 51.7 10.2 84.1s-54 47.3-78.5 33.3zM310.1 189.7c-32.3-10.6-46.9-53.9-32.6-96.8s52.1-69.1 84.4-58.5s46.9 53.9 32.6 96.8s-52.1 69.1-84.4 58.5z"/></svg>
                    <svg class="h-6 w-6 text-neutral-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor"><path d="M226.5 92.9c14.3 42.9-.3 86.2-32.6 96.8s-70.1-15.6-84.4-58.5s.3-86.2 32.6-96.8s70.1 15.6 84.4 58.5zM100.4 198.6c18.9 32.4 14.3 70.1-10.2 84.1s-59.7-.9-78.5-33.3S-2.7 179.3 21.8 165.3s59.7 .9 78.5 33.3zM69.2 401.2C121.6 259.9 214.7 224 256 224s134.4 35.9 186.8 177.2c3.6 9.7 5.2 20.1 5.2 30.5v1.6c0 25.8-20.9 46.7-46.7 46.7c-11.5 0-22.9-1.4-34-4.2l-88-22c-15.3-3.8-31.3-3.8-46.6 0l-88 22c-11.1 2.8-22.5 4.2-34 4.2C84.9 480 64 459.1 64 433.3v-1.6c0-10.4 1.6-20.8 5.2-30.5zM421.8 282.7c-24.5-14-29.1-51.7-10.2-84.1s54-47.3 78.5-33.3s29.1 51.7 10.2 84.1s-54 47.3-78.5 33.3zM310.1 189.7c-32.3-10.6-46.9-53.9-32.6-96.8s52.1-69.1 84.4-58.5s46.9 53.9 32.6 96.8s-52.1 69.1-84.4 58.5z"/></svg>
                    <svg class="h-6 w-6 text-neutral-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor"><path d="M226.5 92.9c14.3 42.9-.3 86.2-32.6 96.8s-70.1-15.6-84.4-58.5s.3-86.2 32.6-96.8s70.1 15.6 84.4 58.5zM100.4 198.6c18.9 32.4 14.3 70.1-10.2 84.1s-59.7-.9-78.5-33.3S-2.7 179.3 21.8 165.3s59.7 .9 78.5 33.3zM69.2 401.2C121.6 259.9 214.7 224 256 224s134.4 35.9 186.8 177.2c3.6 9.7 5.2 20.1 5.2 30.5v1.6c0 25.8-20.9 46.7-46.7 46.7c-11.5 0-22.9-1.4-34-4.2l-88-22c-15.3-3.8-31.3-3.8-46.6 0l-88 22c-11.1 2.8-22.5 4.2-34 4.2C84.9 480 64 459.1 64 433.3v-1.6c0-10.4 1.6-20.8 5.2-30.5zM421.8 282.7c-24.5-14-29.1-51.7-10.2-84.1s54-47.3 78.5-33.3s29.1 51.7 10.2 84.1s-54 47.3-78.5 33.3zM310.1 189.7c-32.3-10.6-46.9-53.9-32.6-96.8s52.1-69.1 84.4-58.5s46.9 53.9 32.6 96.8s-52.1 69.1-84.4 58.5z"/></svg>
                </div>
            </div>

            <!-- Failure header with neutral color -->
            <div class="bg-neutral-700 py-4 px-6">
                <h2 class="text-xl font-semibold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    Order Processing Issue
                </h2>
            </div>

            <!-- Failure content -->
            <div class="p-6">
                <!-- Sad pet image -->
                <div class="flex justify-center mb-4">
                    <div class="w-24 h-24 rounded-full bg-gray-100 flex items-center justify-center">
                        <svg class="h-16 w-16 text-neutral-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor">
                            <path d="M226.5 92.9c14.3 42.9-.3 86.2-32.6 96.8s-70.1-15.6-84.4-58.5s.3-86.2 32.6-96.8s70.1 15.6 84.4 58.5zM100.4 198.6c18.9 32.4 14.3 70.1-10.2 84.1s-59.7-.9-78.5-33.3S-2.7 179.3 21.8 165.3s59.7 .9 78.5 33.3zM69.2 401.2C121.6 259.9 214.7 224 256 224s134.4 35.9 186.8 177.2c3.6 9.7 5.2 20.1 5.2 30.5v1.6c0 25.8-20.9 46.7-46.7 46.7c-11.5 0-22.9-1.4-34-4.2l-88-22c-15.3-3.8-31.3-3.8-46.6 0l-88 22c-11.1 2.8-22.5 4.2-34 4.2C84.9 480 64 459.1 64 433.3v-1.6c0-10.4 1.6-20.8 5.2-30.5zM421.8 282.7c-24.5-14-29.1-51.7-10.2-84.1s54-47.3 78.5-33.3s29.1 51.7 10.2 84.1s-54 47.3-78.5 33.3zM310.1 189.7c-32.3-10.6-46.9-53.9-32.6-96.8s52.1-69.1 84.4-58.5s46.9 53.9 32.6 96.8s-52.1 69.1-84.4 58.5z"/></svg>
                    </div>
                </div>

                <div class="mb-6 bg-gray-100 p-4 rounded-lg border border-gray-200">
                    <p class="text-neutral-800 font-medium text-center">
                        We're sorry, {{$message ?? ""}}.
                    </p>


                </div>

                <!-- Error details -->
                <div class="mb-6 relative">
                    <div class="absolute -left-2 top-3">
                        <svg class="h-5 w-5 text-neutral-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor">
                            <path d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480H40c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24V296c0 13.3 10.7 24 24 24s24-10.7 24-24V184c0-13.3-10.7-24-24-24zm32 224a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-neutral-800 font-semibold mb-3 pl-4">What Happened?</h3>
                    <div class="bg-gray-200 rounded p-4 border-l-4 border-neutral-400">
                        <p class="text-sm text-neutral-700 mb-3">
                            {{ $errorMessage ?? 'We encountered an issue while processing your payment. This could be due to:' }}
                        </p>

                        @if(!isset($errorMessage))
                            <ul class="list-disc pl-5 text-sm text-neutral-700 space-y-1">
                                <li>Insufficient funds in your account</li>
                                <li>Card expired or invalid details</li>
                                <li>Your bank declined the transaction</li>
                                <li>Technical issue with our payment processor</li>
                            </ul>
                        @endif
                    </div>
                </div>

                <!-- Reassurance message -->
                <div class="mb-6 py-3 px-4 bg-gray-50 rounded-lg border border-gray-200 text-sm text-neutral-700 text-center">
                    "Don't worry, your pet supplies are still waiting for you. Let's try again."
                </div>

                <!-- Action buttons -->
                <div class="flex flex-col space-y-3 sm:flex-row sm:space-y-0 sm:space-x-3">
                    <a href="{{ route('home') }}" class="inline-block bg-neutral-600 hover:bg-neutral-700 text-white text-center py-2 px-4 rounded transition-colors duration-200 flex-1 flex items-center justify-center">
                        <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" fill="currentColor"><path d="M575.8 255.5c0 18-15 32.1-32 32.1h-32l.7 160.2c0 2.7-.2 5.4-.5 8.1V472c0 22.1-17.9 40-40 40H456c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1H416 392c-22.1 0-40-17.9-40-40V448 384c0-17.7-14.3-32-32-32H256c-17.7 0-32 14.3-32 32v64 24c0 22.1-17.9 40-40 40H160 128.1c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2H104c-22.1 0-40-17.9-40-40V360c0-.9 0-1.9 .1-2.8V287.6H32c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z"/></svg>
                        Back to Shop
                    </a>
                    <a href="/orders" class="inline-block bg-primary-500 hover:bg-primary-600 text-white text-center py-2 px-4 rounded transition-colors duration-200 flex-1 flex items-center justify-center">
                        <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor"><path d="M368.4 18.3L312.7 74.1 437.9 199.3l55.7-55.7c21.9-21.9 21.9-57.3 0-79.2L447.6 18.3c-21.9-21.9-57.3-21.9-79.2 0zM288 94.6l-9.2 2.8L134.7 140.6c-19.9 6-35.7 21.2-42.3 41L3.8 445.8c-3.8 11.3-1 23.9 7.3 32.4L32 499.8 45.5 512c8.5 8.5 20.8 11.3 32.2 7.5l264.3-88.6c19.8-6.6 35-22.4 41-42.3l43.2-144.1 2.8-9.2L288 94.6zm-5.5 312.7c-3.8 12.7-15.8 21.8-29.2 21.8H112c-13.3 0-24-10.7-24-24V264c0-13.3 10.7-24 24-24h3.2l32 48H184l-32-48h24.9l32 48h8l-32-48H212c10.1 0 19.6-4.7 25.6-12.8L281.9 256h30.7l-29.2 97.4zM112 464h192c13.3 0 24-10.7 24-24v-48H112c-13.3 0-24-10.7-24-24V264c0-13.3 10.7-24 24-24h11l-20-30V175l-16-24H112c-30.9 0-56 25.1-56 56V392c0 30.9 25.1 56 56 56z"/></svg>
                        Try Again
                    </a>
                </div>
            </div>

            <!-- Support contact -->
            <div class="bg-gray-100 py-3 px-6 border-t border-gray-200">
                <p class="text-sm text-neutral-700 text-center">
                    Need assistance? <a href="/contact" class="text-primary-600 hover:text-primary-700 font-medium">Contact us</a>
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
