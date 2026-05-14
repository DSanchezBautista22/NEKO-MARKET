<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>NEKO MARKET</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .bg-discord-main {
            background: radial-gradient(circle at 50% 40%, #31398c 0%, #1d2144 60%, #0b0c10 100%);
        }
        .sticker-static {
            filter: grayscale(100%) brightness(1.8);
            opacity: 0.05;
            pointer-events: none;
            position: absolute;
            user-select: none;
        }
        /* Cristal para la tarjeta de login */
        .glass-card {
            background: rgba(47, 49, 54, 0.6);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="bg-discord-main h-screen w-screen overflow-hidden font-sans antialiased text-white">
    
    <div class="fixed inset-0 z-0 overflow-hidden">
        <img src="{{ asset('images/bg-char-1.png') }}" class="sticker-static left-[5%] top-[18%] w-24" style="transform: rotate(-15deg);">
        <img src="{{ asset('images/bg-char-2.png') }}" class="sticker-static left-[15%] top-[40%] w-16" style="transform: rotate(10deg);">
        <img src="{{ asset('images/bg-char-3.png') }}" class="sticker-static left-[4%] bottom-[25%] w-28" style="transform: rotate(-20deg);">
        <img src="{{ asset('images/bg-char-4.png') }}" class="sticker-static left-[18%] bottom-[12%] w-16" style="transform: rotate(5deg);">

        <img src="{{ asset('images/bg-char-2.png') }}" class="sticker-static right-[7%] top-[15%] w-24" style="transform: rotate(15deg);">
        <img src="{{ asset('images/bg-char-4.png') }}" class="sticker-static right-[18%] top-[38%] w-16" style="transform: rotate(-10deg);">
        <img src="{{ asset('images/bg-char-1.png') }}" class="sticker-static right-[6%] bottom-[18%] w-32" style="transform: rotate(20deg);">
        <img src="{{ asset('images/bg-char-3.png') }}" class="sticker-static right-[15%] bottom-[45%] w-14" style="transform: rotate(-5deg);">

        <img src="{{ asset('images/bg-char-4.png') }}" class="sticker-static left-[35%] top-[12%] w-10 hidden md:block">
        <img src="{{ asset('images/bg-char-1.png') }}" class="sticker-static right-[32%] top-[22%] w-12 hidden md:block">
        <img src="{{ asset('images/bg-char-2.png') }}" class="sticker-static left-[42%] bottom-[18%] w-14 hidden md:block">
        <img src="{{ asset('images/bg-char-3.png') }}" class="sticker-static right-[38%] bottom-[10%] w-10 hidden md:block">
    </div>

    <div class="relative z-10 min-h-screen flex flex-col justify-center items-center px-4">
        <div class="mb-6">
            <a href="/">
                <img src="{{ asset('images/logo.png') }}" class="w-20 h-20 drop-shadow-[0_0_15px_rgba(88,101,242,0.5)]" alt="Logo">
            </a>
        </div>

        <div class="w-full sm:max-w-md px-8 py-10 glass-card shadow-2xl overflow-hidden rounded-3xl relative">
            {{ $slot }}
        </div>
    </div>
    </div>
</body>
</html>