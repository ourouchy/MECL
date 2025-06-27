<div class="w-full relative"
     x-data="{
        activeSlide: 0,
        slides: [],
        loading: true,
        error: null,
        autoplayInterval: null,
        next() { this.activeSlide = (this.activeSlide + 1) % this.slides.length },
        prev() { this.activeSlide = (this.activeSlide - 1 + this.slides.length) % this.slides.length },
        startAutoplay() { this.autoplayInterval = setInterval(() => this.next(), 5000); },
        stopAutoplay() { clearInterval(this.autoplayInterval); }
     }"
     x-init="
        loading = true;
        fetch('/get-carousel-images')
            .then(response => {
                if (!response.ok) throw new Error(`API error: ${response.status}`);
                return response.json();
            })
            .then(data => {
                slides = data;
                loading = false;
                if (slides.length > 1) startAutoplay();
            })
            .catch(err => {
                error = err.message;
                loading = false;
            });
     "
     @mouseenter="stopAutoplay()"
     @mouseleave="slides.length > 1 ? startAutoplay() : null">

    <!-- Loading Message -->
    <div x-show="loading" class="w-full h-64 md:h-96 flex items-center justify-center bg-gray-50">
        <div class="flex flex-col items-center">
            <div class="w-10 h-10 border-4 border-primary-500 border-t-transparent rounded-full animate-spin"></div>
            <p class="text-gray-600 mt-4 font-medium">Chargement du carousel...</p>
        </div>
    </div>

    <!-- Error Message -->
    <div x-show="error" class="w-full h-64 md:h-96 flex items-center justify-center bg-gray-50">
        <div class="flex flex-col items-center text-center px-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <p class="text-red-500 font-medium mt-2" x-text="error"></p>
        </div>
    </div>

    <!-- Carousel Container -->
    <div x-show="!loading && !error && slides.length > 0" class="relative overflow-hidden w-full h-64 md:h-96">

        <!-- Slides Container -->
        <div class="relative h-full flex transition-transform duration-500 ease-in-out"
             :style="`transform: translateX(-${(activeSlide * 100) / slides.length}%); width: ${slides.length * 100}%`">

            <template x-for="(slide, index) in slides" :key="index">
                <div class="h-full flex-shrink-0" :style="`width: ${100 / slides.length}%`">
                    <div class="relative w-full h-full flex items-center justify-center">
                        <img :src="slide.image" class="absolute w-full h-full object-cover" alt="Carousel image" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                        <div class="absolute bottom-6 left-6 md:bottom-10 md:left-10 z-10 max-w-md">
                            <h3 x-show="slide.title" x-text="slide.title" class="text-white text-xl md:text-2xl font-bold mb-2"></h3>
                            <p x-show="slide.description" x-text="slide.description" class="text-white/90 mb-4 text-xs md:text-sm"></p>
                            <a :href="slide.link" target="_blank" x-show="slide.link && slide.link.trim() !== ''">
                                <button class="bg-primary-500 hover:bg-primary-600 transition duration-300 text-white font-bold py-2 px-6 rounded-md uppercase text-xs md:text-sm flex items-center">
                                    <span x-text="slide.button_text || 'Voir plus'"></span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <!-- Navigation Arrows -->
        <template x-if="slides.length > 1">
            <div>
                <button @click="prev(); stopAutoplay();" class="absolute left-2 top-1/2 -translate-y-1/2 z-5  hover:bg-primary-500 text-primary-500 hover:text-white w-8 h-8 md:w-10 md:h-10 rounded-full flex items-center justify-center shadow-md transition-all duration-300 backdrop-blur-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <button @click="next(); stopAutoplay();" class="absolute right-2 top-1/2 -translate-y-1/2 z-5  hover:bg-primary-500 text-primary-500 hover:text-white w-8 h-8 md:w-10 md:h-10 rounded-full flex items-center justify-center shadow-md transition-all duration-300 backdrop-blur-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </template>

        <!-- Indicators -->
        <div class="absolute bottom-2 left-0 right-0 flex justify-center space-x-2 z-5">
            <template x-for="(slide, index) in slides" :key="index">
                <button @click="activeSlide = index; stopAutoplay();"
                        :class="{'bg-white': activeSlide === index, 'bg-secondary/50 hover:bg-white/70': activeSlide !== index}"
                        class="w-2 h-2 rounded-full transition-all duration-300 transform hover:scale-110">
                </button>
            </template>
        </div>
    </div>

    <!-- No Images Message -->
    <div x-show="!loading && !error && slides.length === 0" class="w-full h-64 md:h-80 flex items-center justify-center bg-gray-50">
        <div class="flex flex-col items-center text-center px-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <p class="text-gray-600 font-medium mt-2">Aucune image dans le carousel</p>
        </div>
    </div>
</div>
