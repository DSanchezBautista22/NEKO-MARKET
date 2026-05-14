<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NEKO MARKET</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .bg-discord-main {
            background: radial-gradient(circle at 50% 40%, #31398c 0%, #1d2144 60%, #0b0c10 100%);
        }

        .nav-blur {
            background: rgba(11, 12, 16, 0.4);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        /* Estilo para las pegatinas fijas */
        .sticker-static {
            filter: grayscale(100%) brightness(1.8);
            opacity: 0.07;
            pointer-events: none;
            position: absolute;
            user-select: none;
            /* Añadimos transición para que se vea suave si cambian */
            transition: transform 0.3s ease-in-out; 
        }
    </style>
</head>
<body class="bg-discord-main h-screen w-screen overflow-hidden text-white font-sans antialiased flex flex-col">

    <nav class="nav-blur fixed top-0 w-full z-[100]">
        <div class="max-w-7xl mx-auto px-6 h-14 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <img src="{{ asset('images/logo.png') }}" class="w-8 h-8" alt="Logo">
                <span class="text-lg font-black tracking-tighter uppercase italic">NEKO<span class="text-[#5865F2]">MARKET</span></span>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}" class="bg-white text-[#1D2144] hover:bg-gray-200 px-5 py-1.5 rounded-full font-bold text-[10px] uppercase transition-all duration-300">
                    Iniciar Sesión
                </a>
                <a href="{{ route('register') }}" class="bg-[#5865F2] hover:bg-[#4752C4] text-white px-5 py-1.5 rounded-full font-bold text-[10px] uppercase transition-all duration-300">
                    Registrarse
                </a>
            </div>
        </div>
    </nav>

    <div class="fixed inset-0 z-0 overflow-hidden">
        
        <img src="{{ asset('images/bg-char-1.png') }}" class="sticker-static left-[5%] top-[18%] w-16 md:w-24" style="transform: rotate(-15deg);">
        <img src="{{ asset('images/bg-char-2.png') }}" class="sticker-static left-[15%] top-[40%] w-10 md:w-16" style="transform: rotate(10deg);">
        <img src="{{ asset('images/bg-char-3.png') }}" class="sticker-static left-[4%] bottom-[25%] w-20 md:w-28" style="transform: rotate(-20deg);">
        <img src="{{ asset('images/bg-char-4.png') }}" class="sticker-static left-[18%] bottom-[12%] w-12 md:w-16" style="transform: rotate(5deg);">

        <img src="{{ asset('images/bg-char-2.png') }}" class="sticker-static right-[7%] top-[15%] w-20 md:w-24" style="transform: rotate(15deg);">
        <img src="{{ asset('images/bg-char-4.png') }}" class="sticker-static right-[18%] top-[38%] w-12 md:w-16" style="transform: rotate(-10deg);">
        <img src="{{ asset('images/bg-char-1.png') }}" class="sticker-static right-[6%] bottom-[18%] w-24 md:w-32" style="transform: rotate(20deg);">
        <img src="{{ asset('images/bg-char-3.png') }}" class="sticker-static right-[15%] bottom-[45%] w-10 md:w-14" style="transform: rotate(-5deg);">

        <img src="{{ asset('images/bg-char-4.png') }}" class="sticker-static left-[35%] top-[12%] w-10 hidden md:block" style="transform: rotate(-5deg);">
        <img src="{{ asset('images/bg-char-1.png') }}" class="sticker-static right-[32%] top-[22%] w-12 hidden md:block" style="transform: rotate(8deg);">
        <img src="{{ asset('images/bg-char-2.png') }}" class="sticker-static left-[42%] bottom-[18%] w-14 hidden md:block" style="transform: rotate(-12deg);">
        <img src="{{ asset('images/bg-char-3.png') }}" class="sticker-static right-[38%] bottom-[10%] w-10 hidden md:block" style="transform: rotate(15deg);">

    </div>

    <main class="relative z-10 flex-grow flex flex-col items-center justify-center px-6 mt-14">
        
        <div class="relative mb-6">
            <div class="absolute inset-0 bg-[#5865F2] blur-[120px] opacity-20 rounded-full scale-125"></div>
            <img src="{{ asset('images/hero-neko.png') }}" 
                 alt="Neko Gamer" 
                 class="relative w-full max-w-[260px] md:max-w-[360px] drop-shadow-2xl select-none">
        </div>

        <div class="max-w-2xl text-center">
            <h1 class="text-4xl md:text-6xl font-black uppercase tracking-tighter leading-none mb-4 italic">
                EL REFUGIO <br> 
                <span class="text-white">DE LOS <span class="text-[#5865F2]">TESOROS</span></span>
            </h1>

            <p class="text-gray-400 text-sm md:text-base max-w-md mx-auto font-medium leading-relaxed mb-10 opacity-90">
                La comunidad privada de coleccionistas. <br>
                Encuentra piezas únicas y completa tu colección.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('login') }}" class="w-full sm:w-auto bg-[#5865F2] hover:bg-[#4752C4] text-white px-10 py-3 rounded-2xl font-bold text-base transition-all shadow-lg active:scale-95">
                    Iniciar Sesión
                </a>
                <a href="{{ route('register') }}" class="w-full sm:w-auto bg-white/5 hover:bg-white/10 text-white px-10 py-3 rounded-2xl font-bold text-base transition-all border border-white/10 backdrop-blur-sm">
                    Registrarse
                </a>
            </div>
        </div>
    </main>

</body>
</html>