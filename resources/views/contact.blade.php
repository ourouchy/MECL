<x-app-layout>
    <div class="bg-gray-200 py-16">
        <div class="container">
            <h1 class="text-4xl font-bold text-neutral-800 mb-2">Contact Us</h1>
            <p class="text-lg text-neutral-600">We'd love to hear from you and your furry friends</p>
        </div>
    </div>

    <div class="container py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Contact Form -->
            <div class="lg:col-span-2 bg-white rounded-lg shadow-card p-8" x-data="{ formSubmitted: false, formData: { name: '', email: '', subject: '', message: '', pet_type: '' } }">
                <h2 class="text-2xl font-bold text-primary-600 mb-6">Send Us a Message</h2>

                <!-- Success Message -->
                <div x-show="formSubmitted" x-transition class="bg-primary-50 rounded-lg p-6 shadow-lg text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mx-auto text-primary-500 mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Message Sent Successfully!</h3>
                    <p class="text-gray-600 mb-4">
                        Thank you for reaching out to us. We'll get back to you as soon as possible.
                    </p>
                    <button
                        @click="formSubmitted = false; formData = { name: '', email: '', subject: '', message: '', pet_type: '' }"
                        class="px-6 py-2 bg-primary-500 hover:bg-primary-600 text-white font-medium rounded-md transition duration-300 ease-in-out">
                        Send Another Message
                    </button>
                </div>

                <!-- Form -->
                <form
                    x-show="!formSubmitted"
                    x-transition
                    class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-neutral-700 mb-1">Your Name</label>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                x-model="formData.name"
                                class="w-full rounded-md border-gray-500 focus:border-primary-500 focus:ring focus:ring-primary-200"
                                required>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-neutral-700 mb-1">Email Address</label>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                x-model="formData.email"
                                class="w-full rounded-md border-gray-500 focus:border-primary-500 focus:ring focus:ring-primary-200"
                                required>
                        </div>
                    </div>

                    <div>
                        <label for="subject" class="block text-sm font-medium text-neutral-700 mb-1">Subject</label>
                        <input
                            type="text"
                            name="subject"
                            id="subject"
                            x-model="formData.subject"
                            class="w-full rounded-md border-gray-500 focus:border-primary-500 focus:ring focus:ring-primary-200"
                            required>
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-medium text-neutral-700 mb-1">Your Message</label>
                        <textarea
                            name="message"
                            id="message"
                            rows="6"
                            x-model="formData.message"
                            class="w-full rounded-md border-gray-500 focus:border-primary-500 focus:ring focus:ring-primary-200"
                            required></textarea>
                    </div>

                    <div>
                        <label for="pet_type" class="block text-sm font-medium text-neutral-700 mb-1">Pet Type (Optional)</label>
                        <select
                            name="pet_type"
                            id="pet_type"
                            x-model="formData.pet_type"
                            class="w-full rounded-md border-gray-500 focus:border-primary-500 focus:ring focus:ring-primary-200">
                            <option value="">Select pet type</option>
                            <option value="dog">Dog</option>
                            <option value="cat">Cat</option>
                            <option value="bird">Bird</option>
                            <option value="fish">Fish</option>
                            <option value="small_animal">Small Animal</option>
                            <option value="reptile">Reptile</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div>
                        <button
                            type="button"
                            @click="formSubmitted = true"
                            class="px-6 py-3 bg-primary-500 hover:bg-primary-600 text-white font-medium rounded-md transition duration-300 ease-in-out transform hover:-translate-y-0.5">
                            Send Message
                        </button>
                    </div>
                </form>
            </div>            <!-- Contact Information -->
            <div class="space-y-6">
                <div class="bg-white rounded-lg shadow-card p-8">
                    <h2 class="text-2xl font-bold text-primary-600 mb-6">Our Location</h2>

                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 h-6 w-6 text-secondary-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div class="ml-3 text-neutral-700">
                                <p class="font-medium">Friandos Pet Shop</p>
                                <p>382 Avenue du 15e corps</p>
                                <p>83200 Toulon</p>
                                <p>Provence-Alpes-Côte d'Azur, France</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0 h-6 w-6 text-secondary-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <div class="ml-3 text-neutral-700">
                                <p>+33 4 94 97 XX XX</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0 h-6 w-6 text-secondary-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="ml-3 text-neutral-700">
                                <p>contact@friandos.fr</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-card p-8">
                    <h2 class="text-xl font-bold text-primary-600 mb-4">Store Hours</h2>

                    <div class="space-y-2 text-neutral-700">
                        <div class="flex justify-between">
                            <span>Monday - Friday</span>
                            <span>9:00 - 19:00</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Saturday</span>
                            <span>10:00 - 18:00</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Sunday</span>
                            <span>Closed</span>
                        </div>
                    </div>
                </div>

                <div class="bg-secondary-50 rounded-lg p-6 border border-secondary-200">
                    <h3 class="text-lg font-medium text-accent-700 mb-2">Special Services</h3>
                    <ul class="list-disc list-inside space-y-1 text-neutral-700">
                        <li>Pet grooming appointments</li>
                        <li>Veterinary consultations</li>
                        <li>Product delivery available</li>
                        <li>Pet training sessions</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Map Section -->
        <div class="mt-12 bg-white rounded-lg shadow-card p-6">
            <h2 class="text-2xl font-bold text-primary-600 mb-6">Find Us</h2>
            <div class="aspect-w-16 aspect-h-9 rounded-lg overflow-hidden">
                <div class="w-full h-full bg-gray-300 flex items-center justify-center overflow-hidden rounded-lg shadow-lg">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d8027.592015241953!2d5.919392293610859!3d43.1283753899299!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sfr!2sfr!4v1743999767708!5m2!1sfr!2sfr"
                        class="w-full h-full border-0"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
