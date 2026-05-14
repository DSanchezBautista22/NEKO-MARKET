<nav x-data="{ open: false }" class="bg-[#202225]/90 border-b border-white/5 sticky top-0 z-[100] backdrop-blur-md shadow-2xl">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @php
            $unreadCount = 0;
            try {
                if (Auth::check()) {
                    $unreadCount = \App\Models\Mensaje::where('receptor_id', Auth::id())->where('leido', false)->count();
                }
            } catch (\Exception $e) {
                // silenciar en caso de que el modelo/migración no exista en entornos de test tempranos
                $unreadCount = 0;
            }
        @endphp
        <div class="flex items-center justify-between h-14">
            <!-- Left: logo + primary links -->
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard') }}" class="group flex items-center gap-2">
                    <div class="group-hover:rotate-12 transition-transform duration-300">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-8 h-8 object-contain">
                    </div>
                    <span class="text-lg font-black tracking-tighter text-white uppercase italic hidden xs:block">
                        Neko<span class="text-[#5865F2]">Market</span>
                    </span>
                </a>

                <div class="hidden sm:flex sm:items-center sm:gap-6">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-xs font-bold uppercase tracking-widest">
                        {{ __('Catálogo') }}
                    </x-nav-link>
                    <x-nav-link :href="route('mensajes.index')" :active="request()->routeIs('mensajes.index')" class="relative text-xs font-bold uppercase tracking-widest">
                        {{ __('Mensajes') }}
                        @if($unreadCount > 0)
                            <span class="absolute -top-1 -right-2 h-2 w-2 bg-[#5865F2] rounded-full animate-pulse"></span>
                        @endif
                    </x-nav-link>
                </div>
            </div>

            <!-- Center: search (sm+) -->
            <div class="hidden sm:flex flex-1 justify-center px-4">
                <form method="GET" action="{{ route('productos.search') }}" class="w-full max-w-2xl flex items-center gap-2">
                    <input name="q" type="search" placeholder="Buscar productos..." aria-label="Buscar" class="flex-1 px-3 py-2 rounded-full bg-[#1f2124] border border-white/10 placeholder-gray-400 text-sm text-gray-100 focus:outline-none focus:ring-2 focus:ring-[#5865F2]" />
                    <select name="categoria" class="bg-[#1f2124] text-gray-200 text-sm rounded-full px-3 py-2 border border-white/10">
                        <option value="">Todas las categorías</option>
                        <option value="Cómics">Cómics</option>
                        <option value="Manga">Manga</option>
                        <option value="Figuras">Figuras</option>
                        <option value="Videojuegos">Videojuegos</option>
                        <option value="Consolas">Consolas</option>
                        <option value="Juegos de mesa">Juegos de mesa</option>
                        <option value="Cartas coleccionables">Cartas coleccionables</option>
                        <option value="Merchandising">Merchandising</option>
                        <option value="Libros/artbooks">Libros/artbooks</option>
                        <option value="Pósters">Pósters</option>
                        <option value="Ropa friki">Ropa friki</option>
                        <option value="Funkos">Funkos</option>
                        <option value="Peluches">Peluches</option>
                        <option value="DVDs / Blu-ray">DVDs / Blu-ray</option>
                        <option value="Bandas sonoras / vinilos">Bandas sonoras / vinilos</option>
                        <option value="Miniaturas">Miniaturas</option>
                        <option value="Cosplay">Cosplay</option>
                        <option value="Retro gaming">Retro gaming</option>
                    </select>
                    <button type="submit" class="text-sm bg-[#5865F2] px-4 py-2 rounded-full text-white font-bold hover:bg-[#4752C4]">Buscar</button>
                </form>
            </div>

            <!-- Right: actions (Vender + user) -->
            <div class="flex items-center gap-4">
                <div class="hidden sm:flex sm:items-center sm:gap-4">
                    <a href="{{ route('vender') }}" class="bg-[#5865F2] hover:bg-[#4752C4] text-white text-xs font-black px-4 py-2 rounded-lg transition-all shadow-lg uppercase tracking-wider">
                        + Vender
                    </a>

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-2 px-2 py-1 rounded-full bg-[#2f3136] border border-white/5 hover:border-[#5865F2]/50 transition-all">
                                @if(optional(Auth::user())->avatar_path)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar_path) }}" alt="Avatar" class="w-6 h-6 rounded-full object-cover">
                                @else
                                    <div class="w-6 h-6 bg-[#5865F2] rounded-full flex items-center justify-center text-[10px] font-bold text-white uppercase">
                                        {{ substr(optional(Auth::user())->name ?? 'U', 0, 1) }}
                                    </div>
                                @endif
                                <svg class="w-3 h-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')"> Perfil </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-400 font-bold"> Salir </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- Mobile menu button -->
                <div class="sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-gray-400 hover:text-white hover:bg-[#2f3136] transition-all">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div 
        x-show="open" 
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4"
        @click.away="open = false"
        class="absolute inset-x-0 top-14 z-[110] sm:hidden bg-gradient-to-b from-[#26282b]/95 to-[#151617]/95 backdrop-blur-xl border-b border-white/6 shadow-[0_30px_60px_rgba(0,0,0,0.6)] overflow-hidden"
    >
        <div class="pt-4 pb-6 px-4 space-y-3">

                <!-- Mobile search (full width) -->
                <form method="GET" action="{{ route('productos.search') }}" class="mb-4">
                    <div class="flex gap-2">
                        <input name="q" type="search" placeholder="Buscar productos..." class="w-full px-4 py-3 rounded-lg bg-[#1b1c1d] text-gray-100 placeholder-gray-400 ring-1 ring-white/5 focus:outline-none focus:ring-2 focus:ring-[#5865F2]" />
                        <button type="submit" class="bg-gradient-to-br from-[#5865F2] to-[#4752C4] text-white px-4 py-3 rounded-lg font-bold shadow-lg hover:opacity-95">Ir</button>
                    </div>
                    <div class="mt-2">
                        <select name="categoria" class="w-full bg-[#1b1c1d] text-gray-200 rounded-lg px-3 py-2 ring-1 ring-white/5 focus:outline-none">
                            <option value="">Todas las categorías</option>
                            <option value="Cómics">Cómics</option>
                            <option value="Manga">Manga</option>
                            <option value="Figuras">Figuras</option>
                            <option value="Videojuegos">Videojuegos</option>
                            <option value="Consolas">Consolas</option>
                            <option value="Juegos de mesa">Juegos de mesa</option>
                            <option value="Cartas coleccionables">Cartas coleccionables</option>
                            <option value="Merchandising">Merchandising</option>
                            <option value="Libros/artbooks">Libros/artbooks</option>
                            <option value="Pósters">Pósters</option>
                            <option value="Ropa friki">Ropa friki</option>
                            <option value="Funkos">Funkos</option>
                            <option value="Peluches">Peluches</option>
                            <option value="DVDs / Blu-ray">DVDs / Blu-ray</option>
                            <option value="Bandas sonoras / vinilos">Bandas sonoras / vinilos</option>
                            <option value="Miniaturas">Miniaturas</option>
                            <option value="Cosplay">Cosplay</option>
                            <option value="Retro gaming">Retro gaming</option>
                        </select>
                    </div>
                </form>

            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-lg font-bold rounded-xl border-none text-white px-3 py-2 hover:bg-[#1f2022]">
                {{ __('Catálogo') }}
            </x-responsive-nav-link>
            
            <x-responsive-nav-link :href="route('mensajes.index')" :active="request()->routeIs('mensajes.index')" class="text-lg font-bold rounded-xl border-none flex justify-between items-center text-white px-3 py-2 hover:bg-[#1f2022]">
                {{ __('Mis Mensajes') }}
                @if($unreadCount > 0)
                    <span class="bg-[#5865F2] text-[10px] px-2 py-0.5 rounded-full text-white">NUEVO</span>
                @endif
            </x-responsive-nav-link>

            <div class="pt-4">
                <a href="{{ route('vender') }}" class="flex justify-center w-full bg-gradient-to-br from-[#5865F2] to-[#4752C4] text-white py-3 rounded-2xl font-black uppercase tracking-tighter shadow-lg">
                    + Vender un Producto
                </a>
            </div>

            <div class="border-t border-white/6 my-4 pt-4">
                <div class="flex items-center px-2 mb-4">
                    <div class="w-10 h-10 rounded-full overflow-hidden">
                        @if(optional(Auth::user())->avatar_path)
                            <img src="{{ asset('storage/' . Auth::user()->avatar_path) }}" alt="Avatar" class="w-10 h-10 object-cover rounded-full">
                        @else
                            <div class="w-10 h-10 bg-gradient-to-br from-[#5865F2] to-[#4752C4] rounded-full flex items-center justify-center font-bold text-white shadow-lg">{{ substr(Auth::user()->name, 0, 1) }}</div>
                        @endif
                    </div>
                    <div class="ms-3 text-left">
                        <div class="font-bold text-white">{{ optional(Auth::user())->name ?? 'Usuario' }}</div>
                        <div class="text-xs text-gray-400 italic">#{{ optional(Auth::user())->id ?? '000' }}026</div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <x-responsive-nav-link :href="route('profile.edit')" class="text-center bg-[#1f2022] rounded-xl border-none py-3 font-bold text-white hover:bg-[#2a2b2d]">
                        {{ __('Perfil') }}
                    </x-responsive-nav-link>
                    
                    <form method="POST" action="{{ route('logout') }}" class="contents">
                        @csrf
                        <button type="submit" class="text-center bg-red-600/10 text-red-300 rounded-xl py-3 font-bold text-sm border border-red-500/10 hover:bg-red-600/5">
                            {{ __('Salir') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>