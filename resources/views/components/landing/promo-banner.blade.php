@props([
    'title',
    'subtitle' => null,
    'description' => null,
    'ctaText' => null, // We will override this dynamically if needed
    'ctaLink' => null,
    'image',
    'backgroundColor' => 'bg-secondary',
    'textColor' => 'text-white',
    'layout' => 'left',
        'overrideCta' => false,
])

@php
    $imgOrder = $layout === 'left' ? 'md:order-2' : 'md:order-1';
    $contentOrder = $layout === 'left' ? 'md:order-1' : 'md:order-2';

    // Handle CTA for guest vs user
       $overrideCta = isset($overrideCta) ? $overrideCta : false; // Default false

    if ($overrideCta) {
        $finalCtaText = $ctaText;
        $finalCtaLink = $ctaLink;
    } else {
        if (auth()->check()) {
            $finalCtaText = 'Shop Now';
            $finalCtaLink = route('products.index');
        } else {
            $finalCtaText = $ctaText ?? 'Sign Up Now';
            $finalCtaLink = $ctaLink ?? route('register');
        }
    }
@endphp

<section class="py-12 {{ $backgroundColor }}">
    <div class="container">
        <div class="flex flex-col md:flex-row items-center">
            {{-- Image --}}
            <div class="w-full md:w-1/2 mb-8 md:mb-0 {{ $imgOrder }}">
                <img
                    src="{{ $image }}"
                    alt="{{ $title }}"
                    class="w-full h-auto rounded-lg shadow-lg"
                />
            </div>

            {{-- Text content --}}
            <div class="w-full md:w-1/2 md:px-8 {{ $contentOrder }}">
                <div class="max-w-lg mx-auto">
                    @if($subtitle)
                        <p class="{{ $textColor }} text-lg mb-2 opacity-90">
                            {{ $subtitle }}
                        </p>
                    @endif

                    <h2 class="{{ $textColor }} text-3xl md:text-4xl font-bold mb-4">
                        {{ $title }}
                    </h2>

                    @if($description)
                        <p class="{{ $textColor }} text-lg mb-6 opacity-90">
                            {{ $description }}
                        </p>
                    @endif

                    <a
                        href="{{ $finalCtaLink }}"
                        class="btn bg-white text-secondary hover:bg-gray-100 px-6 py-3 font-medium shadow-md"
                    >
                        {{ $finalCtaText }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
