<x-app-layout>
    <div class="container mx-auto px-4 py-12">

        <!-- Hero Section -->
        <section class="relative bg-primary-500 text-white">
            <div class="container mx-auto py-24 px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                    <div class="order-2 lg:order-1">
                        <h1 class="text-4xl md:text-5xl font-bold mb-4">Our Story</h1>
                        <p class="text-xl mb-6">Committed to the wellbeing of pets and their humans since 2015.</p>
                        <p class="mb-8">
                            At Friandós, we believe every pet deserves the best care, the finest products, and a loving forever home.
                            Our journey began with a simple mission: to create a place where pet lovers could find everything they need
                            while supporting animal welfare. Over the years, we’ve expanded into a <strong>one-stop pet shop</strong>
                            serving <em>all pets – from dogs and cats to birds, reptiles, fish, and small mammals</em>. Our shelves are filled
                            with premium foods, engaging toys, healthy supplements, and habitat essentials from top brands like
                            <span class="font-semibold">Royal Canin, Purina, Kaytee, Tetra</span>, and more, ensuring every pet
                            parent can find exactly what they need under one roof.
                        </p>
                    </div>
                    <div class="order-1 lg:order-2">
                        <img
                            src="{{ asset('images/about-us-hero.jpg') }}"
                            alt="Friandós team with pets"
                            class="rounded-lg shadow-lg w-full h-auto object-cover"
                            onerror="this.src='https://images.unsplash.com/photo-1548199973-03cce0bbc87b?ixlib=rb-1.2.1&auto=format&fit=crop&w=2850&q=80'"
                        >
                    </div>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-16 bg-white" style="clip-path: polygon(0 100%, 100% 0, 100% 100%, 0% 100%);"></div>
        </section>

        <!-- Mission & Values -->
        <section class="py-16 bg-white">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-neutral-800 mb-2">Our Mission & Values</h2>
                    <div class="w-24 h-1 bg-primary-500 mx-auto mb-6"></div>
                    <p class="text-lg text-neutral-600 max-w-3xl mx-auto">
                        We're dedicated to improving the lives of pets and strengthening the bond between animals and their humans.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12">
                    <!-- Value 1 -->
                    <div class="bg-gray-100 p-8 rounded-lg shadow-card hover:shadow-lg transition-shadow duration-300">
                        <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mb-6 mx-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                                />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-neutral-800 mb-3 text-center">Quality First</h3>
                        <p class="text-neutral-600 text-center">
                            We carefully source and test every product we offer, ensuring only the best for your beloved companions.
                            From <span class="font-semibold">vet-approved dog and cat foods</span> to
                            <span class="font-semibold">nutritious bird seed blends</span> and <span class="font-semibold">aquarium-safe decor</span>,
                            each item meets our high standards for health and safety.
                        </p>
                    </div>

                    <!-- Value 2 -->
                    <div class="bg-gray-100 p-8 rounded-lg shadow-card hover:shadow-lg transition-shadow duration-300">
                        <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mb-6 mx-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-neutral-800 mb-3 text-center">Ethical Practices</h3>
                        <p class="text-neutral-600 text-center">
                            We partner with responsible suppliers and donate a portion of every sale to animal welfare organizations.
                            Our commitment extends to <em>all</em> pets, so we support dog, cat, bird, reptile, and small-mammal rescues
                            through <span class="font-semibold">food donations, supplies</span>, and direct funding.
                        </p>
                    </div>

                    <!-- Value 3 -->
                    <div class="bg-gray-100 p-8 rounded-lg shadow-card hover:shadow-lg transition-shadow duration-300">
                        <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mb-6 mx-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                                />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-neutral-800 mb-3 text-center">Community Focus</h3>
                        <p class="text-neutral-600 text-center">
                            We build connections between pet lovers, rescue organizations, and animal advocates to create a better world
                            for all animals. Our events and workshops – from dog training and cat adoption days to aquarium clubs and reptile
                            care seminars – bring the community together in support of every species.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Our Team -->
        <section class="py-16 bg-gray-100">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-neutral-800 mb-2">Meet Our Furry Management Team</h2>
                    <div class="w-24 h-1 bg-primary-500 mx-auto mb-6"></div>
                    <p class="text-lg text-neutral-600 max-w-3xl mx-auto">
                        At Friandos, we believe no one understands pets better than pets themselves! That's why our shop is
                        proudly run by the most qualified four-legged (and winged!) professionals in the business.
                        From selecting the tastiest treats to organizing perfect adoption matches, our animal experts
                        are here to help families of all species live their best lives together.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Team Member 1 -->
                    <div class="bg-white rounded-lg overflow-hidden shadow-card hover:shadow-lg transition-shadow duration-300">
                        <div class="aspect-w-1 aspect-h-1">
                            <img
                                src="{{asset('images/maine_coon_about.png')}}"
                                alt="Captain Whiskers"
                                class="object-cover"
                            >
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-neutral-800 mb-1">Captain Whiskers</h3>
                            <p class="text-sm text-primary-600 mb-3">Founder & CEO (Chief Exploring Officer)</p>
                            <p class="text-neutral-600 mb-4">
                                This distinguished Maine Coon with 9 lives of business experience founded Friandos after realizing pets
                                deserved better shopping options. Captain Whiskers personally tests every cat product and has a
                                discerning eye for quality scratching posts and premium catnip toys.
                            </p>
                            <div class="flex space-x-3">
                                <a href="#" class="text-neutral-500 hover:text-primary-600">
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path
                                            fill-rule="evenodd"
                                            d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </a>
                                <a href="#" class="text-neutral-500 hover:text-primary-600">
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path
                                            d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"
                                        />
                                    </svg>
                                </a>
                                <a href="#" class="text-neutral-500 hover:text-primary-600">
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path
                                            fill-rule="evenodd"
                                            d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Team Member 2 -->
                    <div class="bg-white rounded-lg overflow-hidden shadow-card hover:shadow-lg transition-shadow duration-300">
                        <div class="aspect-w-1 aspect-h-1">
                            <img
                                src="{{asset('images/golden_retrieve_about.png')}}"
                                alt="Roxy Ruffsalot"
                                class="object-cover"
                            >
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-neutral-800 mb-1">Roxy Ruffsalot</h3>
                            <p class="text-sm text-primary-600 mb-3">Head of Adoption Matchmaking</p>
                            <p class="text-neutral-600 mb-4">
                                This intuitive Golden Retriever has an uncanny talent for pairing pets with their perfect humans.
                                With 7 years of tail-wagging expertise in family compatibility, Roxy personally interviews each
                                potential adopter and ensures they go home with the right supplies for their new family member.
                            </p>
                            <div class="flex space-x-3">
                                <!-- Social icons repeated as above... -->
                            </div>
                        </div>
                    </div>

                    <!-- Team Member 3 -->
                    <div class="bg-white rounded-lg overflow-hidden shadow-card hover:shadow-lg transition-shadow duration-300">
                        <div class="aspect-w-1 aspect-h-1">
                            <img
                                src="{{asset('images/gray_parrot_about.png')}}"
                                alt="Professor Feathers"
                                class="object-cover"
                            >
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-neutral-800 mb-1">Professor Feathers</h3>
                            <p class="text-sm text-primary-600 mb-3">Nutrition Specialist</p>
                            <p class="text-neutral-600 mb-4">
                                This brilliant African Grey Parrot holds advanced degrees in avian nutrition and has expanded our
                                product offerings to include the finest <span class="font-semibold">vitamin-fortified bird seed</span>,
                                <span class="font-semibold">reptile pellets</span>, and exotic pet cuisine. Prof. Feathers personally
                                taste-tests every food item in our inventory.
                            </p>
                            <div class="flex space-x-3">
                                <!-- Social icons repeated as above... -->
                            </div>
                        </div>
                    </div>

                    <!-- Team Member 4 -->
                    <div class="bg-white rounded-lg overflow-hidden shadow-card hover:shadow-lg transition-shadow duration-300">
                        <div class="aspect-w-1 aspect-h-1">
                            <img
                                src="{{asset('images/betta_fish_about.png')}}"
                                alt="Bubbles McFin"
                                class="object-cover"
                            >
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-neutral-800 mb-1">Bubbles McFin</h3>
                            <p class="text-sm text-primary-600 mb-3">Aquatic Community Director</p>
                            <p class="text-neutral-600 mb-4">
                                This charismatic Betta fish coordinates our popular <span class="font-semibold">aquarium club meets</span>
                                and oversees our extensive selection of underwater habitats. Bubbles also hosts our weekend
                                <span class="font-semibold">small pet workshops</span>, teaching proper care for everything from
                                guppies to goldfish.
                            </p>
                            <div class="flex space-x-3">
                                <!-- Social icons repeated as above... -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Our Impact -->
        <section class="py-16 bg-white">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-neutral-800 mb-2">Our Impact</h2>
                    <div class="w-24 h-1 bg-primary-500 mx-auto mb-6"></div>
                    <p class="text-lg text-neutral-600 max-w-3xl mx-auto">
                        Since 2015, we've been making a difference in the lives of pets and their humans.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 text-center">
                    <div>
                        <div class="text-5xl font-bold text-primary-600 mb-2">10,000+</div>
                        <p class="text-neutral-700 font-medium">Pets Adopted</p>
                    </div>
                    <div>
                        <div class="text-5xl font-bold text-primary-600 mb-2">€250K</div>
                        <p class="text-neutral-700 font-medium">Donated to Shelters</p>
                    </div>
                    <div>
                        <div class="text-5xl font-bold text-primary-600 mb-2">50+</div>
                        <p class="text-neutral-700 font-medium">Partner Organizations</p>
                    </div>
                    <div>
                        <div class="text-5xl font-bold text-primary-600 mb-2">35,000+</div>
                        <p class="text-neutral-700 font-medium">Happy Customers</p>
                    </div>
                </div>

                <div class="mt-16 bg-gray-100 rounded-lg p-6 md:p-10">
                    <div class="flex flex-col md:flex-row items-center">
                        <div class="mb-6 md:mb-0 md:mr-10 flex-shrink-0">
                            <img
                                src="{{ asset('images/testimonial-avatar.jpg') }}"
                                alt="Customer Testimonial"
                                class="w-24 h-24 rounded-full object-cover mx-auto"
                                onerror="this.src='https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80'"
                            >
                        </div>
                        <div>
                            <svg class="h-8 w-8 text-primary-400 mb-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                            </svg>
                            <p class="text-lg text-neutral-600 italic mb-4">
                                Friandós has changed my life and my pet's life for the better. Not only did I find the perfect companion,
                                but I also discovered a community of animal lovers who truly care. The team's expertise and dedication make
                                this more than just a pet store—it's a lifeline for animals in need.
                            </p>
                            <p class="font-medium text-neutral-800">Émilie Gagnon</p>
                            <p class="text-sm text-neutral-500">Happy Pet Parent</p>
                        </div>
                    </div>
                    <p class="text-neutral-700 mt-6 leading-relaxed">
                        By offering premium nutrition and specialized supplies across all species, we're helping local rescues
                        and shelters provide quality care for a wide range of pets—dogs, cats, birds, reptiles, and even small mammals.
                        Each year, we donate food, bedding, and other essential items to these organizations to ensure animals awaiting
                        adoption thrive while they wait for their forever homes.
                    </p>
                </div>
            </div>
        </section>

        <!-- Join Our Community -->
        <section class="py-16 bg-gray-100">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-primary-600 rounded-lg overflow-hidden shadow-xl">
                    <div class="grid grid-cols-1 lg:grid-cols-2">
                        <div class="p-10 lg:p-16">
                            <h2 class="text-3xl font-bold text-white mb-4">Join Our Community</h2>
                            <p class="text-primary-100 mb-8">
                                Be part of our mission to create a better world for pets. Sign up for our newsletter
                                to receive updates, animal welfare tips, and exclusive offers.
                            </p>
                            <form class="space-y-4">
                                <div>
                                    <label for="name" class="sr-only">Name</label>
                                    <input
                                        type="text"
                                        id="name"
                                        name="name"
                                        class="w-full rounded-md px-4 py-3 text-neutral-800 placeholder-neutral-500"
                                        placeholder="Your Name"
                                    >
                                </div>
                                <div>
                                    <label for="email" class="sr-only">Email</label>
                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        class="w-full rounded-md px-4 py-3 text-neutral-800 placeholder-neutral-500"
                                        placeholder="Your Email"
                                    >
                                </div>
                                <div>
                                    <button
                                        type="submit"
                                        class="w-full bg-white text-primary-600 font-medium rounded-md px-6 py-3 hover:bg-primary-50 transition-colors duration-300"
                                    >
                                        Subscribe Now
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="hidden lg:block relative">
                            <img
                                src="{{ asset('images/community.jpg') }}"
                                alt="Happy pets and owners"
                                class="absolute inset-0 w-full h-full object-cover"
                                onerror="this.src='https://images.unsplash.com/photo-1552053831-71594a27632d?ixlib=rb-1.2.1&auto=format&fit=crop&w=612&q=80'"
                            >
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Locations -->
        <section class="py-16 bg-white">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-neutral-800 mb-2">Visit Us</h2>
                    <div class="w-24 h-1 bg-primary-500 mx-auto mb-6"></div>
                    <p class="text-lg text-neutral-600 max-w-3xl mx-auto">
                        Stop by one of our locations to meet our team and discover how we can help you and your pets.
                        Each store features dedicated sections for dogs, cats, birds, reptiles, fish, and small mammals—
                        so you’ll always find exactly what you need for your best friend.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Location 1 -->
                    <div class="bg-gray-100 rounded-lg overflow-hidden shadow-card hover:shadow-lg transition-shadow duration-300">
                        <div class="aspect-w-16 aspect-h-9">
                            <img
                                src="{{ asset('images/location-1.jpg') }}"
                                alt="Paris Store"
                                class="object-cover"
                                onerror="this.src='https://images.unsplash.com/photo-1573843981267-be1999ff37cd?ixlib=rb-1.2.1&auto=format&fit=crop&w=1050&q=80'"
                            >
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-neutral-800 mb-2">Paris</h3>
                            <div class="flex items-start mb-4">
                                <svg
                                    class="h-5 w-5 text-primary-600 mt-0.5 mr-2"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998
                                        1.998 0 01-2.827 0l-4.244-4.243a8 8
                                        0 1111.314 0z"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0
                                        016 0z"
                                    />
                                </svg>
                                <p class="text-neutral-600">
                                    123 Avenue des Champs-Élysées<br>
                                    75008 Paris, France
                                </p>
                            </div>
                            <div class="flex items-start mb-4">
                                <svg
                                    class="h-5 w-5 text-primary-600 mt-0.5 mr-2"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9
                                        0 11-18 0 9 9 0 0118 0z"
                                    />
                                </svg>
                                <p class="text-neutral-600">
                                    Mon-Sat: 9am - 7pm<br>
                                    Sun: 10am - 5pm
                                </p>
                            </div>
                            <div class="flex items-start">
                                <svg
                                    class="h-5 w-5 text-primary-600 mt-0.5 mr-2"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1
                                        1 0 01.948.684l1.498 4.493a1
                                        1 0 01-.502 1.21l-2.257 1.13a11.042
                                        11.042 0 005.516 5.516l1.13-2.257a1
                                        1 0 011.21-.502l4.493 1.498a1
                                        1 0 01.684.949V19a2 2 0
                                        01-2 2h-1C9.716 21 3 14.284
                                        3 6V5z"
                                    />
                                </svg>
                                <p class="text-neutral-600">+33 1 23 45 67 89</p>
                            </div>
                        </div>
                    </div>

                    <!-- Location 2 -->
                    <div class="bg-gray-100 rounded-lg overflow-hidden shadow-card hover:shadow-lg transition-shadow duration-300">
                        <div class="aspect-w-16 aspect-h-9">
                            <img
                                src="{{ asset('images/location-2.jpg') }}"
                                alt="Lyon Store"
                                class="object-cover"
                                onerror="this.src='https://images.unsplash.com/photo-1601929862217-f1bf94503333?ixlib=rb-1.2.1&auto=format&fit=crop&w=1050&q=80'"
                            >
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-neutral-800 mb-2">Lyon</h3>
                            <div class="flex items-start mb-4">
                                <svg
                                    class="h-5 w-5 text-primary-600 mt-0.5 mr-2"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M17.657 16.657L13.414
                                        20.9a1.998 1.998 0
                                        01-2.827 0l-4.244-4.243a8
                                        8 0 1111.314 0z"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3
                                        3 0 016 0z"
                                    />
                                </svg>
                                <p class="text-neutral-600">
                                    456 Rue de la République<br>
                                    69002 Lyon, France
                                </p>
                            </div>
                            <div class="flex items-start mb-4">
                                <svg
                                    class="h-5 w-5 text-primary-600 mt-0.5 mr-2"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9
                                        9 0 11-18 0 9 9 0 0118
                                        0z"
                                    />
                                </svg>
                                <p class="text-neutral-600">
                                    Mon-Sat: 9am - 7pm<br>
                                    Sun: 10am - 5pm
                                </p>
                            </div>
                            <div class="flex items-start">
                                <svg
                                    class="h-5 w-5 text-primary-600 mt-0.5 mr-2"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M3 5a2 2 0
                                        012-2h3.28a1 1 0
                                        01.948.684l1.498
                                        4.493a1 1 0
                                        01-.502 1.21l-2.257
                                        1.13a11.042 11.042 0
                                        005.516 5.516l1.13-2.257a1
                                        1 0 011.21-.502l4.493
                                        1.498a1 1 0 01.684.949V19a2
                                        2 0 01-2 2h-1C9.716 21
                                        3 14.284 3
                                        6V5z"
                                    />
                                </svg>
                                <p class="text-neutral-600">+33 4 56 78 90 12</p>
                            </div>
                        </div>
                    </div>

                    <!-- Location 3 -->
                    <div class="bg-gray-100 rounded-lg overflow-hidden shadow-card hover:shadow-lg transition-shadow duration-300">
                        <div class="aspect-w-16 aspect-h-9">
                            <img
                                src="{{ asset('images/location-3.jpg') }}"
                                alt="Marseille Store"
                                class="object-cover"
                                onerror="this.src='https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?ixlib=rb-1.2.1&auto=format&fit=crop&w=1049&q=80'"
                            >
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-neutral-800 mb-2">Marseille</h3>
                            <div class="flex items-start mb-4">
                                <svg
                                    class="h-5 w-5 text-primary-600 mt-0.5 mr-2"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M17.657 16.657L13.414
                                        20.9a1.998 1.998 0
                                        01-2.827 0l-4.244-4.243a8
                                        8 0 1111.314 0z"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3
                                        0 016 0z"
                                    />
                                </svg>
                                <p class="text-neutral-600">
                                    789 La Canebière<br>
                                    13001 Marseille, France
                                </p>
                            </div>
                            <div class="flex items-start mb-4">
                                <svg
                                    class="h-5 w-5 text-primary-600 mt-0.5 mr-2"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 8v4l3
                                        3m6-3a9 9 0
                                        11-18 0 9 9 0
                                        0118 0z"
                                    />
                                </svg>
                                <p class="text-neutral-600">
                                    Mon-Sat: 9am - 7pm<br>
                                    Sun: 10am - 5pm
                                </p>
                            </div>
                            <div class="flex items-start">
                                <svg
                                    class="h-5 w-5 text-primary-600 mt-0.5 mr-2"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M3 5a2 2 0
                                        012-2h3.28a1 1 0
                                        01.948.684l1.498
                                        4.493a1 1 0
                                        01-.502 1.21l-2.257
                                        1.13a11.042 11.042 0
                                        005.516 5.516l1.13-2.257a1
                                        1 0 011.21-.502l4.493
                                        1.498a1 1 0 01.684.949V19a2
                                        2 0 01-2 2h-1C9.716 21
                                        3 14.284 3
                                        6V5z"
                                    />
                                </svg>
                                <p class="text-neutral-600">+33 4 91 23 45 67</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
