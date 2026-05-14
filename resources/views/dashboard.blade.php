<x-app-layout>
    <div class="py-8 sm:py-12 bg-[#36393f] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10 border-b border-white/5 pb-8">
                <div>
                    <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tighter uppercase italic">
                        Catálogo <span class="text-[#5865F2]">Global</span>
                    </h2>
                    <p class="text-gray-400 text-sm sm:text-base mt-1 font-medium">
                        Explora los últimos tesoros de la comunidad friki.
                    </p>
                </div>

                <div class="hidden md:block">
                    <a href="{{ route('vender') }}" class="text-gray-400 hover:text-white text-xs font-bold uppercase tracking-widest transition-colors flex items-center gap-2">
                        ¿Quieres vender algo? <span class="text-[#5865F2]">Publicar aquí →</span>
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-8 bg-green-500/10 border border-green-500/50 text-green-400 p-4 rounded-2xl font-bold flex items-center gap-3 animate-bounce">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-8 bg-red-500/10 border border-red-500/50 text-red-400 p-4 rounded-2xl font-bold flex items-center gap-3">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-8">
                @forelse($productos as $producto)
                    <div class="group bg-[#2f3136] rounded-3xl overflow-hidden shadow-xl border border-white/5 hover:border-[#5865F2]/50 hover:shadow-[0_20px_40px_rgba(0,0,0,0.4)] transition-all duration-500 flex flex-col">
                        
                        <div class="aspect-[4/5] bg-[#202225] overflow-hidden relative">
                            @if($producto->imagen_url)
                                <img src="{{ asset('storage/' . $producto->imagen_url) }}" 
                                     alt="{{ $producto->titulo }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-5xl opacity-10">👾</div>
                            @endif
                            
                            <div class="absolute top-3 right-3 bg-[#202225]/80 backdrop-blur-md border border-white/10 text-white px-3 py-1 rounded-full font-black text-sm shadow-xl">
                                {{ $producto->precio == intval($producto->precio) ? number_format($producto->precio, 0, ',', '.') : number_format($producto->precio, 2, ',', '.') }}€
                            </div>

                            <div class="absolute inset-0 bg-[#5865F2]/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <a href="{{ route('productos.show', $producto->id) }}" class="bg-white text-[#202225] px-4 py-2 rounded-full font-black text-xs uppercase tracking-tighter transform translate-y-4 group-hover:translate-y-0 transition-transform shadow-2xl">
                                    Ver Detalles
                                </a>
                            </div>
                        </div>

                        <div class="p-4 flex flex-col flex-grow">
                            <h3 class="text-white font-bold text-sm sm:text-base leading-tight truncate mb-1 group-hover:text-[#5865F2] transition-colors">
                                {{ $producto->titulo }}
                            </h3>
                            
                            <div class="flex items-center gap-2 mb-4">
                                <span class="text-[10px] font-black uppercase tracking-widest text-gray-500 bg-[#202225] px-2 py-0.5 rounded border border-white/5">
                                    {{ $producto->estado_conservacion }}
                                </span>
                            </div>

                            <div class="mt-auto sm:hidden">
                                <a href="{{ route('productos.show', $producto->id) }}" class="block w-full text-center bg-[#5865F2] text-white py-2 rounded-xl text-[10px] font-black uppercase">
                                    Ver más
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center bg-[#2f3136] rounded-3xl border-2 border-dashed border-white/5">
                        <h3 class="text-xl font-bold text-white uppercase tracking-tighter">El almacén está vacío</h3>
                        <p class="text-gray-500 mt-2">Sé el primero en publicar un tesoro en la comunidad.</p>
                        <a href="{{ route('vender') }}" class="mt-6 inline-block text-[#5865F2] font-bold hover:underline">Vender algo ahora →</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>