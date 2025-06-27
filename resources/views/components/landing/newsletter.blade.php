<section class="py-12 bg-primary" x-data="{ email: '', subscribed: false }">
    <div class="container">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="text-2xl md:text-3xl font-bold text-white mb-3">
                Join Our Furry Friends Community
            </h2>
            <p class="text-white text-opacity-90 mb-8 text-lg">
                Subscribe to our newsletter for exclusive offers, pet care tips, and new product alerts.
            </p>

            <!-- Success Message -->
            <div x-show="subscribed" x-transition class="bg-white rounded-lg p-6 shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mx-auto text-primary mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Thank You for Subscribing!</h3>
                <p class="text-gray-600">
                    You're now part of our community. Watch your inbox for pet-tastic updates!
                </p>
            </div>

            <!-- Form -->
            <form
                x-show="!subscribed"
                x-on:submit.prevent="
                    if (email.includes('@')) {
                        subscribed = true;
                        email = '';
                    }
                "
                x-transition
                class="flex flex-col sm:flex-row gap-3 max-w-xl mx-auto"
            >
                <input
                    type="email"
                    x-model="email"
                    placeholder="Your email address"
                    class="flex-grow px-4 py-3 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-white"
                    required
                />
                <button
                    type="submit"
                    class="btn bg-secondary hover:bg-secondary-600 text-white font-medium px-6 py-3 rounded-md shadow-sm"
                >
                    Subscribe
                </button>
            </form>

            <p class="text-white text-opacity-70 mt-4 text-sm">
                By subscribing, you agree to our Privacy Policy and consent to receive updates from PetParadise.
            </p>
        </div>
    </div>
</section>
