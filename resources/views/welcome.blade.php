<x-app-layout>

    {{-- Hero Banner --}}
    <x-landing.hero-banner
        title="Your Pet Deserves The Best"
        subtitle="Premium products for your furry, feathered or scaly friends. Free shipping on orders over € 49!"
        cta-text="Shop Now"
        cta-link="/products"
        background-image="/images/hero-banner.jpg"
    />
    {{-- Categories --}}
    <x-landing.category-section
        title="Shop By Pet"
        :categories="[
        ['id' => 'cat', 'name' => 'Cat', 'image' => '/images/cat-kitten.jpg', 'link' => '/products/category/cat'],
        ['id' => 'dog', 'name' => 'Dog', 'image' => '/images/dog-toy.jpg', 'link' => '/products/category/dog'],
        ['id' => 'fish', 'name' => 'Fish', 'image' => '/images/nemo.png', 'link' => '/products/category/fish'],
        ['id' => 'Birds', 'name' => 'Birds', 'image' => '/images/oiseau1.png', 'link' => '/products/category/bird'],
        ['id' => 'pets', 'name' => 'Small pets', 'image' => '/images/smallpets.jpg', 'link' => '/products/category/smallpets'],
        ['id' => 'reptiles', 'name' => 'Reptiles', 'image' => '/images/reptiles.png', 'link' => '/products/category/reptile'],

    ]"
    />
    {{-- Featured Products --}}
    <x-landing.featured-products
        title="Featured Products"
        :products="$products"
        viewAllLink="/products"
    />

    {{-- Promo Banner --}}
    <x-landing.promo-banner

        title="Save 20% on Your First Order"
        subtitle="New Customer Special"
        description="Sign up for our newsletter and receive a 20% discount code for your first purchase. Plus get access to exclusive deals and pet care tips!"
        ctaText="Sign Up Now"
        ctaLink="/register"
        image="/images/cat-dog-friends.jpg"
        backgroundColor="bg-secondary"
        layout="right"
    />
     {{-- New Arrivals --}}
    <x-landing.featured-products :products="$newArrivals" title="New Arrivals" viewAllLink="{{ route('products.index') }}" />
    <x-landing.promo-banner
        title="Join Our Adoption Program"
        subtitle="Find A Forever Friend"
        description="PetParadise partners with local shelters to help pets find loving homes. Browse available pets or register to become a foster parent."
        ctaText="See More"
        ctaLink="/adoption-program"
        image="/images/dog-toy.jpg"
        backgroundColor="bg-primary"
        layout="left"
        :overrideCta="true"
    />

      {{-- Second Promo Banner --}}
{{--  <x-landing.newsletter /> --}}

{{--    <x-landing.treats-section
       :products="$products"
       dogViewAllLink="/products/dog-treats"
       catViewAllLink="/products/cat-treats"
   /> --}}

    <x-landing.newsletter
    />




</x-app-layout>
