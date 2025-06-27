@if ($category->banner_image)
    <div class="h-60 flex items-center justify-center">
        <img src="{{ asset('storage/' . $category->banner_image) }}"
             alt="{{ $category->name }}"
             class="w-full h-full object-cover rounded-lg shadow" />
    </div>
@endif

<div class="p-6 bg-white">
    <h1 class="text-2xl font-bold mb-2">{{ $category->name }}</h1>
    @if($category->description)
        <p class="text-gray-700">{{ $category->description }}</p>
    @endif
</div>
