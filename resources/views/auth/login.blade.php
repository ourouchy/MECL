<x-app-layout>
    <div class="flex min-h-screen bg-gradient-to-br from-primary-50 to-primary-100">
        <!-- Authentication Side -->
        <div class="w-full md:w-1/2 flex items-center justify-center p-8">
            <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8 border-t-4 border-primary-500">
                <!-- Logo -->
                <div class="text-center mb-8">
                    <div class="flex items-center justify-center">
                    <img class="max-h-14 pr-1" src="{{ asset('images/logo.png') }}" alt="friandos">
                    </div>
                    <p class="text-neutral-500 italic">Premium pet products for beloved companions</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="w-full">
                    <h2 class="text-2xl font-semibold text-center mb-5 text-neutral-800">
                        Welcome Back!
                    </h2>
                    <p class="text-center text-neutral-500 mb-6">
                        New pet parent?
                        <a href="{{ route('register') }}" class="text-sm text-primary-500 hover:text-primary-600 font-medium">
                            Create an account
                        </a>
                    </p>

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')"/>

                    @csrf
                    <div class="mb-4">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-neutral-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                            </div>
                            <x-input type="email" name="email" placeholder="Your email address" :value="old('email')" class="w-full pl-10 p-3 border border-gray-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-400"/>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-neutral-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <x-input type="password" name="password" placeholder="Your password" :value="old('password')" class="w-full pl-10 p-3 border border-gray-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-400"/>
                        </div>
                    </div>
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center">
                            <input
                                id="loginRememberMe"
                                type="checkbox"
                                class="mr-3 rounded border-gray-500 text-primary-500 focus:ring-primary-400"
                            />
                            <label for="loginRememberMe" class="text-neutral-600">Remember Me</label>
                        </div>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-primary-500 hover:text-primary-600 font-medium">
                                Forgot Password?
                            </a>
                        @endif
                    </div>
                    <button
                        class="w-full py-3 px-4 bg-gradient-to-r from-primary-500 to-primary-600 text-white font-bold rounded-lg transition duration-300 transform hover:scale-[1.02] hover:shadow-lg flex items-center justify-center"
                    >
                        <span>Login</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div class="mt-6 flex items-center justify-center">
                        <span class="bg-gray-500 h-px flex-grow"></span>
                        <span class="px-4 text-sm text-neutral-500">or continue with</span>
                        <span class="bg-gray-500 h-px flex-grow"></span>
                    </div>

                    <div class="mt-4 flex space-x-3">
                        <button type="button" class="flex-1 py-2 px-4 border border-gray-500 rounded-lg hover:bg-gray-300 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-accent-600" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z" />
                            </svg>
                        </button>
                        <button type="button" class="flex-1 py-2 px-4 border border-gray-500 rounded-lg hover:bg-gray-300 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-secondary-500" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-2.917 16.083c-2.258 0-4.083-1.825-4.083-4.083s1.825-4.083 4.083-4.083c1.103 0 2.024.402 2.735 1.067l-1.107 1.068c-.304-.292-.834-.63-1.628-.63-1.394 0-2.531 1.155-2.531 2.579 0 1.424 1.138 2.579 2.531 2.579 1.616 0 2.224-1.162 2.316-1.762h-2.316v-1.4h3.855c.036.204.064.408.064.677.001 2.332-1.563 3.988-3.919 3.988zm9.917-3.5h-1.75v1.75h-1.167v-1.75h-1.75v-1.166h1.75v-1.75h1.167v1.75h1.75v1.166z" />
                            </svg>
                        </button>
                        <button type="button" class="flex-1 py-2 px-4 border border-gray-500 rounded-lg hover:bg-gray-300 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-accent-700" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-2 16h-2v-6h2v6zm-1-6.891c-.607 0-1.1-.496-1.1-1.109 0-.612.492-1.109 1.1-1.109s1.1.497 1.1 1.109c0 .613-.493 1.109-1.1 1.109zm8 6.891h-1.998v-2.861c0-1.881-2.002-1.722-2.002 0v2.861h-2v-6h2v1.093c.872-1.616 4-1.736 4 1.548v3.359z" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Image Side -->
        <div class="hidden md:block md:w-1/2 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-primary-600 to-primary-800 opacity-90"></div>
            <div class="absolute inset-0 bg-[url('/api/placeholder/600/800')] bg-cover bg-center mix-blend-overlay"></div>

            <div class="absolute inset-0 flex flex-col justify-center items-center p-8">
                <div class="max-w-md text-center z-10">
                    <div class="mb-6 flex justify-center">
                        <!-- Pet illustration -->
                        <div class="relative">
                            <img src="{{ asset('images/1517090.svg') }}" alt="Logo" class="max-h-48 " />

                        </div>
                    </div>
                    <h3 class="text-3xl font-bold text-white mb-4">Paw-some Products Await!</h3>
                    <p class="text-primary-100 text-lg mb-8">Premium selections for your furry, feathered, and finned family members.</p>

                    <!-- Testimonial -->


                    <!-- Features -->
                    <div class="grid grid-cols-3 gap-4 mt-8">
                        <div class="bg-white bg-opacity-10 p-4 rounded-lg backdrop-blur-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-secondary-300 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <p class="text-white text-sm">Free shipping starting at 49€</p>
                        </div>
                        <div class="bg-white bg-opacity-10 p-4 rounded-lg backdrop-blur-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-secondary-300 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-white text-sm">Guaranteed quality</p>
                        </div>
                        <div class="bg-white bg-opacity-10 p-4 rounded-lg backdrop-blur-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-secondary-300 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-white text-sm">24/7 Support</p>
                        </div>
                    </div>

                    <!-- Featured products -->
                    <div class="mt-8 grid grid-cols-2 gap-4">
                        <div class="bg-white bg-opacity-10 p-4 rounded-lg backdrop-blur-sm border border-white border-opacity-10">
                            <div class="bg-secondary-400 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                </svg>
                            </div>
                            <h4 class="text-white font-medium text-sm">Premium Food</h4>
                            <p class="text-primary-100 text-xs mt-1">Organic and natural</p>
                        </div>
                        <div class="bg-white bg-opacity-10 p-4 rounded-lg backdrop-blur-sm border border-white border-opacity-10">
                            <div class="bg-secondary-400 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                </svg>
                            </div>
                            <h4 class="text-white font-medium text-sm">Fun toys</h4>
                            <p class="text-primary-100 text-xs mt-1">Enrichment and games</p>
                        </div>
                    </div>
                </div>
                <img src="{{ asset('images/cat-laying-down-6.png') }}" class="absolute -left-[45%] top-[55%] scale-75">
            </div>

            <!-- Decorative elements -->
            <div class="absolute bottom-0 left-0 right-0">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="text-white opacity-10">
                    <path fill="currentColor" fill-opacity="1" d="M0,96L48,122.7C96,149,192,203,288,208C384,213,480,171,576,165.3C672,160,768,192,864,218.7C960,245,1056,267,1152,266.7C1248,267,1344,245,1392,234.7L1440,224L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
                </svg>
            </div>
        </div>
    </div>
</x-app-layout>
