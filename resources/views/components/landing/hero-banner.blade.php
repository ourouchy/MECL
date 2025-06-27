@props([
    'title' => 'Your Pet Deserves The Best',
    'subtitle' => 'Premium products for your furry, feathered or scaly friends. Free shipping on orders over €49!',
    'ctaText' => 'Shop Now',
    'ctaLink' => '/products',
    'backgroundImage' => '/images/hero-banner.jpg'
])

<div
    class="relative h-96 md:h-[450px] lg:h-[500px] w-full bg-cover bg-center overflow-hidden"
    style="background-image: url('{{ $backgroundImage }}')"
>
    <!-- Overlay gradient -->
    <div class="absolute inset-0 bg-gradient-to-r from-neutral-900/70 to-transparent"></div>

    <!-- Content -->
    <div class="container relative h-full flex items-center">
        <div class="max-w-xl text-white">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4">
                {{ $title }}
            </h1>
            <p class="text-lg md:text-xl mb-8 text-gray-100">
                {{ $subtitle }}
            </p>
            <a
                href="{{ $ctaLink }}"
                class="btn-secondary px-6 py-3 text-base font-medium"
            >
                {{ $ctaText }}
            </a>
        </div>
    </div>
</div>
