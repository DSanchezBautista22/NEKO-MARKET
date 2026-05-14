<x-app-layout>
    <div class="py-12 bg-[#36393f] min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-white mb-6 inline-flex items-center gap-2 transition-colors font-bold tracking-wide">
                <span>←</span> Volver al catálogo
            </a>

            <div class="bg-[#2f3136] rounded-3xl overflow-hidden shadow-2xl border border-gray-700/50 flex flex-col md:flex-row">
                
                <div class="md:w-1/2 bg-[#202225] flex items-center justify-center p-4 min-h-[400px]">
                    @if($producto->imagen_url)
                        <img src="{{ asset('storage/' . $producto->imagen_url) }}" alt="{{ $producto->titulo }}" class="max-h-[500px] w-full object-contain drop-shadow-2xl hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="text-8xl opacity-20">📦</div>
                    @endif
                </div>

                <div class="md:w-1/2 p-8 md:p-12 flex flex-col">
                    <div class="flex justify-between items-start mb-6">
                        <h1 class="text-3xl font-black text-white leading-tight">{{ $producto->titulo }}</h1>
                        <div class="text-3xl font-bold text-[#5865F2] whitespace-nowrap ml-4">{{ number_format($producto->precio, 2, ',', '.') }} €</div>
                    </div>

                    <div class="flex flex-wrap items-center gap-3 mb-8">
                        <span class="px-4 py-1.5 bg-[#202225] text-gray-300 text-xs font-bold rounded-full border border-gray-600 uppercase tracking-widest shadow-inner">
                            {{ $producto->estado_conservacion }}
                        </span>
                        @if($producto->tiene_caja_original)
                            <span class="px-4 py-1.5 bg-yellow-500/10 text-yellow-400 text-xs font-bold rounded-full border border-yellow-500/30 uppercase tracking-widest shadow-inner">
                                Con Caja
                            </span>
                        @endif
                    </div>

                    <div class="text-gray-400 leading-relaxed mb-10 flex-grow">
                        <h3 class="text-gray-500 font-bold mb-3 uppercase text-xs tracking-widest border-b border-gray-700 pb-2">Descripción del artículo</h3>
                        <p class="text-lg text-gray-300 whitespace-pre-line">{{ $producto->descripcion }}</p>
                    </div>

                    <div class="mt-auto pt-6 border-t border-gray-700 flex items-center justify-between mb-8">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full overflow-hidden">
                                @if(optional($producto->user)->avatar_path)
                                    <img src="{{ asset('storage/' . $producto->user->avatar_path) }}" alt="Avatar" class="w-12 h-12 object-cover rounded-full shadow-lg">
                                @else
                                    <div class="w-12 h-12 bg-gradient-to-br from-[#5865F2] to-[#4752C4] rounded-full flex items-center justify-center font-bold text-white shadow-lg text-xl">{{ strtoupper(substr($producto->user->name, 0, 1)) }}</div>
                                @endif
                            </div>
                            <div>
                                <div class="text-white font-bold text-base">{{ $producto->user->name }}</div>
                                @if($producto->user->email_verified_at)
                                    <div class="text-[#5865F2] text-xs font-bold uppercase tracking-wider flex items-center gap-1">
                                        ✓ Vendedor Verificado
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4">
                        <div class="mt-4">
                            <form action="{{ route('mensajes.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="receptor_id" value="{{ $producto->user_id }}">
                                <input type="hidden" name="producto_id" value="{{ $producto->id }}">
        
                            <textarea name="contenido" rows="2" required 
                                class="w-full bg-[#202225] border-gray-600 rounded-xl text-white text-sm mb-2 focus:ring-[#5865F2]"
                                placeholder="Escribe tu mensaje para el vendedor..."></textarea>
            
                            <button type="submit" class="w-full bg-[#5865F2] hover:bg-[#4752C4] text-white font-bold py-4 rounded-xl transition-all shadow-lg text-lg flex justify-center items-center gap-2">
                                Enviar mensaje al vendedor 
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>