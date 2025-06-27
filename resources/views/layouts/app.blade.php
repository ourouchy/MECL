<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="/favicon.png" />
    <title>{{ config('app.name', 'Friandos') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>
<body>
@include('layouts.navigation')
<div class="sm:h-[133px] h-[88px]"></div>

<main>

    {{ $slot }}
</main>
<x-footer />

<!-- Toast -->
<div
    x-data="toast"
    x-show="visible"
    x-transition
    x-cloak
    @notify.window="show($event.detail.message, $event.detail.type || 'success')"
    class="fixed bottom-8 left-1/2 -translate-x-1/2 w-full max-w-sm rounded-2xl shadow-xl text-white overflow-hidden z-50"
    :class="type === 'success' ? 'bg-primary-500' : 'bg-rose-500'"
>
    <div class="relative px-5 py-4">
        <div class="font-semibold text-base" x-text="message"></div>
        <button
            @click="close"
            class="absolute top-2 right-2 w-8 h-8 rounded-full flex items-center justify-center hover:bg-white/10 transition-colors"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M6 18L18 6M6 6l12 12"
                />
            </svg>
        </button>
        <!-- Progress -->
        <div class="absolute left-0 bottom-0 right-0 h-[4px] bg-white/20">
            <div
                class="h-full bg-white/60 transition-all duration-300"
                :style="{'width': `${percent}%`}"
            ></div>
        </div>
    </div>
</div>
<!--/ Toast -->
</body>
</html>
