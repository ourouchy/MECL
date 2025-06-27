@if (!empty($breadcrumbs))
    <nav class="mb-6 ml-6 sm:ml-0" aria-label="Breadcrumb">

        <ol class="flex flex-wrap items-center text-sm">
            @foreach ($breadcrumbs as $breadcrumb)
                <li class="flex items-center {{ $loop->last ? 'font-semibold' : '' }}">
                    @if ($breadcrumb['url'])
                        <a href="{{ $breadcrumb['url'] }}" class="text-primary-600 hover:text-primary-800 hover:underline transition-colors duration-200">
                            {{ $breadcrumb['name'] }}
                        </a>
                        @if (!$loop->last)
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mx-2 text-gray-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        @endif
                    @else
                        <span class="text-gray-800">{{ $breadcrumb['name'] }}</span>
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>
@endif
