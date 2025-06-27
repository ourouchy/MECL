<x-app-layout>
<div class="bg-gray-100">
    <!-- Hero Section with Background Image -->
    <div class="relative bg-secondary-400 py-20">
        <div class="absolute inset-0 overflow-hidden opacity-20">
            <img src="{{url('https://images.unsplash.com/photo-1450778869180-41d0601e046e?q=80&w=1886&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D')}}" alt="Pet collage" class="w-full h-full object-cover">
        </div>
        <div class="container relative z-10">
            <div class="max-w-3xl mx-auto text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Our Adoption Program</h1>
                <p class="text-2xl text-white mb-6">A Loving Home for Every Pet</p>
                <p class="text-white text-lg leading-relaxed">
                    Friandós isn't just a pet supply store – we're also a community of animal lovers dedicated to helping dogs and cats in need. Our Adoption Program is at the heart of this mission.
                </p>
            </div>
        </div>
        <!-- Decorative Wave Shape -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" fill="#F8F8F7" preserveAspectRatio="none" class="w-full h-12">
                <path d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z"></path>
            </svg>
        </div>
    </div>

    <!-- Introduction Section with Pet Image -->
    <div class="container py-16">
        <div class="bg-white rounded-lg shadow-card p-8 md:p-0 overflow-hidden">
            <div class="md:flex">
                <div class="md:w-1/2 md:order-2">
                    <img src="{{url('https://www.shutterstock.com/image-photo/hug-happy-woman-dog-nature-600nw-2488357593.jpg')}}" alt="Happy adopted dog" class="w-full h-full object-cover">
                </div>
                <div class="md:w-1/2 p-8 flex items-center">
                    <div class="prose max-w-none text-neutral-800">
                        <h2 class="text-3xl font-bold text-primary-600 mb-6">We Believe Every Pet Deserves a Chance</h2>
                        <p class="text-lg mb-4">
                            Through our program, we match homeless pets with caring families, ensuring each adoption is a positive, joyful experience for everyone involved.
                        </p>
                        <p class="text-lg">
                            Our friendly, compassionate team will be by your side every step of the way, making the journey of adoption rewarding and stress-free.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Adoption Process Section -->
    <div id="process" class="container py-16">
        <h2 class="text-3xl font-bold text-secondary-600 mb-8 text-center">How the Adoption Process Works</h2>
        <p class="text-lg text-center mb-12 max-w-3xl mx-auto">
            We strive to make the adoption process simple and thorough, with the well-being of our pets and peace of mind for adopters as top priorities.
        </p>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Step 1 -->
            <div class="bg-white rounded-lg shadow-card p-6 hover:shadow-lg transition-shadow duration-300 border-t-4 border-secondary-400 group hover:-translate-y-1 transition-transform">
                <div class="w-16 h-16 bg-secondary-100 rounded-full flex items-center justify-center text-secondary-600 font-bold text-2xl mb-4 group-hover:bg-secondary-200 transition-colors">1</div>
                <h3 class="text-xl font-bold text-secondary-500 mb-3">Meet Our Pets</h3>
                <p class="text-neutral-700 mb-4">
                    Start by getting to know the dogs and cats looking for a home. Browse online or visit the Friandós store in person.
                </p>
                <img src="{{url('https://images.unsplash.com/photo-1526363269865-60998e11d82d?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D')}}" alt="Meeting pets" class="w-full h-32 object-cover rounded-md">
            </div>

            <!-- Step 2 -->
            <div class="bg-white rounded-lg shadow-card p-6 hover:shadow-lg transition-shadow duration-300 border-t-4 border-primary-400 group hover:-translate-y-1 transition-transform">
                <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 font-bold text-2xl mb-4 group-hover:bg-primary-200 transition-colors">2</div>
                <h3 class="text-xl font-bold text-primary-500 mb-3">Submit Your Application</h3>
                <p class="text-neutral-700 mb-4">
                    Once you've found a furry friend you're interested in, fill out our adoption application online or in-store.
                </p>
                <img src="{{url('https://images.unsplash.com/photo-1520168133788-3c084821ec1f?q=80&w=2080&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D')}}" alt="Application process" class="w-full h-32 object-cover rounded-md">
            </div>

            <!-- Step 3 -->
            <div class="bg-white rounded-lg shadow-card p-6 hover:shadow-lg transition-shadow duration-300 border-t-4 border-secondary-400 group hover:-translate-y-1 transition-transform">
                <div class="w-16 h-16 bg-secondary-100 rounded-full flex items-center justify-center text-secondary-600 font-bold text-2xl mb-4 group-hover:bg-secondary-200 transition-colors">3</div>
                <h3 class="text-xl font-bold text-secondary-500 mb-3">Adoption Counseling</h3>
                <p class="text-neutral-700 mb-4">
                    Our adoption coordinators will review your application and ensure you and the pet are a perfect match. won't be long we promise !
                </p>
                <img src="{{url('https://images.unsplash.com/photo-1683744579737-bc47bb7edbb3?q=80&w=2122&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D')}}" alt="Adoption counseling" class="w-full h-32 object-cover rounded-md">
            </div>

            <!-- Step 4 -->
            <div class="bg-white rounded-lg shadow-card p-6 hover:shadow-lg transition-shadow duration-300 border-t-4 border-primary-400 group hover:-translate-y-1 transition-transform">
                <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 font-bold text-2xl mb-4 group-hover:bg-primary-200 transition-colors">4</div>
                <h3 class="text-xl font-bold text-primary-500 mb-3">Bring Your Pet Home</h3>
                <p class="text-neutral-700 mb-4">
                    Once approved, we complete the adoption paperwork together and your new family member goes home with you!
                </p>
                <img src="{{url('https://images.unsplash.com/photo-1544047963-99e58dfea839?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D')}}" alt="Going home with pet" class="w-full h-32 object-cover rounded-md">
            </div>
        </div>
    </div>


    <!-- What's Included Section with Paw Prints -->
    <div class="container py-16 relative">
        <div class="absolute top-0 right-0 transform -translate-y-1/2">
            <img src="/images/paw-prints.svg" alt="Paw prints" class="w-32 h-32 opacity-20">
        </div>

        <h2 class="text-3xl font-bold text-secondary-600 mb-8 text-center">Every Adopted Pet Includes</h2>

        <div class="bg-gradient-to-br from-secondary-50 to-primary-50 rounded-lg p-8 border border-secondary-100 shadow-lg">
            <div class="grid md:grid-cols-2 gap-8">
                <div class="flex items-start bg-white p-4 rounded-lg shadow-sm">
                    <div class="flex-shrink-0 mr-4">
                        <div class="w-12 h-12 bg-secondary-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-secondary-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg text-secondary-500 mb-1">Full Veterinary Health Check</h3>
                        <p class="text-neutral-700">Each pet is thoroughly examined by a veterinarian to ensure they're healthy.</p>
                    </div>
                </div>

                <div class="flex items-start bg-white p-4 rounded-lg shadow-sm">
                    <div class="flex-shrink-0 mr-4">
                        <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-primary-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg text-primary-500 mb-1">Up-to-date Vaccinations</h3>
                        <p class="text-neutral-700">All core shots are completed, so your pet is protected against common illnesses.</p>
                    </div>
                </div>

                <div class="flex items-start bg-white p-4 rounded-lg shadow-sm">
                    <div class="flex-shrink-0 mr-4">
                        <div class="w-12 h-12 bg-secondary-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-secondary-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg text-secondary-500 mb-1">Microchip Identification</h3>
                        <p class="text-neutral-700">Your pet will have a microchip ID for permanent safety, already implanted and registered.</p>
                    </div>
                </div>

                <div class="flex items-start bg-white p-4 rounded-lg shadow-sm">
                    <div class="flex-shrink-0 mr-4">
                        <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-primary-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg text-primary-500 mb-1">Spay or Neuter Surgery</h3>
                        <p class="text-neutral-700">All our dogs and cats are sterilized to help control pet overpopulation and ensure better health.</p>
                    </div>
                </div>
            </div>

            <div class="mt-8 p-6 bg-white rounded-lg shadow-sm">
                <p class="text-lg text-neutral-700 text-center">
                    Your adopted friend is fully vetted and ready to start their new life with you, without any immediate medical procedures needed. We take care of their health needs upfront so you can focus on bonding with your new companion.
                </p>
            </div>
        </div>
    </div>

    <!-- Partners Section with Image -->
    <div class="container py-16">
        <div class="md:flex items-center gap-8">
            <div class="md:w-1/2 mb-8 md:mb-0">
                <img src="{{url('https://plus.unsplash.com/premium_photo-1679523690066-3a433e6a8ed5?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D')}}" alt="Shelter partnership" class="w-full h-full object-cover rounded-lg shadow-lg">
            </div>
            <div class="md:w-1/2">
                <h2 class="text-3xl font-bold text-primary-600 mb-6">Partnering with Shelters & Rescues</h2>
                <div class="prose max-w-none text-neutral-700">
                    <p class="mb-4">
                        Friandós is proud to work closely with local animal shelters and rescue organizations on an ongoing basis. Through these partnerships, we welcome dogs and cats from our partner shelters into our adoption program.
                    </p>
                    <p class="mb-4">
                        By adopting a pet from Friandós, you're not only gaining a wonderful companion, but also supporting the hard work of these shelters and rescue groups. Together with our partners, we share the same mission: to give every animal a second chance at happiness and a loving home.
                    </p>
                    <p>
                        We also host regular adoption events and initiatives in collaboration with rescue groups, so keep an eye on our announcements. Every adoption helps the wider community of animal rescuers and opens up space for another pet in need.
                    </p>
                </div>
                <div class="mt-6">
                    <a href="" class="inline-block bg-primary-500 hover:bg-primary-600 text-white px-6 py-2 rounded-md transition-colors">Join our Newsletter</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Testimonials Section with Pet Photos -->
    <div class="bg-gradient-to-r from-primary-50 to-secondary-50 py-16">
        <div class="container">
            <h2 class="text-3xl font-bold text-primary-600 mb-12 text-center">Stories from Happy Adopters</h2>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <!-- Testimonial 1 -->
                <div class="bg-white p-6 rounded-lg shadow-card hover:shadow-lg transition-shadow">

                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-secondary-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-secondary-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-neutral-700">The Williams Family</div>
                        </div>
                    </div>
                    <p class="text-neutral-700 italic">
                        "Adopting our cat from Friandós was a wonderful experience. The staff was so supportive and matched us with the perfect furry companion for our family."
                    </p>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-white p-6 rounded-lg shadow-card hover:shadow-lg transition-shadow">

                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-primary-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-neutral-700">The Johnson Family</div>
                        </div>
                    </div>
                    <p class="text-neutral-700 italic">
                        "As soon as we met our puppy at Friandós, we knew he was the one. Now our home feels whole, and we can't imagine life without him."
                    </p>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-white p-6 rounded-lg shadow-card hover:shadow-lg transition-shadow">

                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-secondary-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-secondary-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-neutral-700">Margaret T.</div>
                        </div>
                    </div>
                    <p class="text-neutral-700 italic">
                        "Adopting my cat Whiskers has brought so much joy to my retirement. The Friandós team helped me find the perfect companion for my lifestyle."
                    </p>
                </div>
            </div>

            <div class="text-center mt-12">
                <p class="text-lg text-neutral-700 mb-6">
                    These heartfelt stories are just a glimpse of the many happy endings made possible by our adoption program. Your story could be next!
                </p>
            </div>
        </div>
    </div>

    <!-- CTA Section with Background Image -->
    <div class="container py-16">
        <div class="relative bg-secondary-500 text-white rounded-lg shadow-xl p-8 text-center overflow-hidden">
            <!-- Background Image with Overlay -->
            <div class="absolute inset-0 z-0">
                <img src="/images/pets/dogs-and-cats-together.jpg" alt="Dogs and cats" class="w-full h-full object-cover opacity-20">
                <div class="absolute inset-0 bg-gradient-to-r from-secondary-600 to-primary-600 opacity-80"></div>
            </div>

            <div class="relative z-10 max-w-4xl mx-auto">
                <h2 class="text-3xl md:text-4xl font-bold mb-6">Ready to Meet Your New Best Friend?</h2>
                <div class="max-w-2xl mx-auto">
                    <p class="text-lg mb-8">
                        Your new best friend could be waiting for you at Friandós. Whether you're looking for a playful puppy, a loyal adult dog, a cuddly kitten, or a calm senior cat, we're here to help you find the perfect match.
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                        <a href="/contact" class="bg-primary-600 text-white hover:bg-primary-700 px-8 py-4 rounded-full font-bold transition-colors duration-300 shadow-lg">Visit Us Today</a>
                    </div>
                </div>

                <!-- Decorative Paw Icons -->
                <div class="absolute bottom-4 left-4 opacity-30">
                    <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                        <path d="M256,224c-79.4,0-192,122.75-192,200.25C64,459.24,90.75,480,134,480s38.62-23.5,63-23.5S247.25,480,278,480c44.25,0,70-20.75,70-55.75C348,346.75,335.4,224,256,224Z"></path>
                        <path d="M352,144a32,32,0,0,0,32-32c0-18.25-16-48-48-48s-32,29.75-32,48A32,32,0,0,0,352,144Z"></path>
                        <path d="M448,144c16,0,32-14,32-32,0-16-16-48-48-48s-32,32-32,48C400,130,432,144,448,144Z"></path>
                        <path d="M176,128a32,32,0,0,0,32-32c0-18.25-16-48-48-48s-32,29.75-32,48A32,32,0,0,0,176,128Z"></path>
                        <path d="M64,128c16,0,32-14,32-32,0-16-16-48-48-48S16,80,16,96C16,114,48,128,64,128Z"></path>
                    </svg>
                </div>
                <div class="absolute top-4 right-4 opacity-30">
                    <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                        <path d="M256,224c-79.4,0-192,122.75-192,200.25C64,459.24,90.75,480,134,480s38.62-23.5,63-23.5S247.25,480,278,480c44.25,0,70-20.75,70-55.75C348,346.75,335.4,224,256,224Z"></path>
                        <path d="M352,144a32,32,0,0,0,32-32c0-18.25-16-48-48-48s-32,29.75-32,48A32,32,0,0,0,352,144Z"></path>
                        <path d="M176,128a32,32,0,0,0,32-32c0-18.25-16-48-48-48s-32,29.75-32,48A32,32,0,0,0,176,128Z"></path>
                        <path d="M64,128c16,0,32-14,32-32,0-16-16-48-48-48S16,80,16,96C16,114,48,128,64,128Z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="container py-16">
        <h2 class="text-3xl font-bold text-secondary-600 mb-8 text-center">Frequently Asked Questions</h2>

        <div class="max-w-3xl mx-auto">
            <div class="mb-6">
                <h3 class="text-xl font-bold text-primary-500 mb-2">What is the adoption fee?</h3>
                <p class="text-neutral-700">
                    Our adoption fees vary by animal type and age. Dogs typically range from $150-250, while cats range from $75-150. These fees help cover the costs of vaccinations, spay/neuter procedures, microchipping, and other medical care.
                </p>
            </div>

            <div class="mb-6">
                <h3 class="text-xl font-bold text-primary-500 mb-2">How long does the adoption process take?</h3>
                <p class="text-neutral-700">
                    The adoption process usually takes 2-5 days, depending on the individual case. We work to make the process as quick as possible while ensuring each pet goes to the right home.
                </p>
            </div>

            <div class="mb-6">
                <h3 class="text-xl font-bold text-primary-500 mb-2">Can I foster a pet before adopting?</h3>
                <p class="text-neutral-700">
                    Yes, we do offer foster-to-adopt programs for certain situations. This can be a great way to ensure the pet is a good match for your home before finalizing the adoption.
                </p>
            </div>

            <div class="mb-6">
                <h3 class="text-xl font-bold text-primary-500 mb-2">What support does Friandós offer after adoption?</h3>
                <p class="text-neutral-700">
                    We provide post-adoption support including behavior advice, recommended veterinary care, and pet supplies at member discounts. Our team is always available to answer questions and offer guidance as you and your new pet adjust to life together.
                </p>
            </div>
        </div>
    </div>

</div>
</x-app-layout>
