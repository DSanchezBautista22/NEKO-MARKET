<x-app-layout>
    <div class="py-12 bg-[#36393f] min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex justify-between items-center mb-8 border-b border-gray-700 pb-4">
                <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tighter uppercase italic">
                    Tus <span class="text-[#5865F2]">Mensajes</span>
                </h2>
            </div>

            @if(session('success'))
                <div class="mb-6 bg-green-500/10 border border-green-500 text-green-400 p-4 rounded-xl font-bold shadow-lg">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 bg-red-500/10 border border-red-500 text-red-400 p-4 rounded-xl font-bold shadow-lg">
                    {{ session('error') }}
                </div>
            @endif

            <div class="flex items-center gap-3 mb-6">
                <a href="{{ route('mensajes.index') }}" class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-bold transition-colors {{ request()->routeIs('mensajes.index') ? 'bg-[#5865F2] text-white shadow-lg' : 'bg-[#1f2022] text-gray-200 hover:bg-[#2a2b2d]' }}">
                    Recibidos
                    @if(isset($unreadCount) && $unreadCount > 0)
                        <span class="ms-3 inline-flex items-center justify-center bg-red-500 text-white text-xs font-black px-2 py-0.5 rounded-full">{{ $unreadCount }}</span>
                    @endif
                </a>
                <a href="{{ route('mensajes.enviados') }}" class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-bold transition-colors {{ request()->routeIs('mensajes.enviados') ? 'bg-[#5865F2] text-white shadow-lg' : 'bg-[#1f2022] text-gray-200 hover:bg-[#2a2b2d]' }}">
                    Enviados
                </a>
            </div>

            <div class="space-y-4">
                @forelse($mensajes as $mensaje)
                    @php
                        $esMio = $mensaje->emisor_id === Auth::id();
                    @endphp

                    <div class="bg-[#2f3136] rounded-2xl p-6 shadow-xl border {{ $esMio ? 'border-gray-700/50' : 'border-[#5865F2]/50' }} hover:border-[#5865F2] transition-colors relative overflow-hidden">
                        
                        <div class="absolute left-0 top-0 bottom-0 w-1 {{ $esMio ? 'bg-gray-600' : 'bg-[#5865F2]' }}"></div>

                        <div class="flex justify-between items-start mb-4 pl-2">
                            <div>
                                <span class="text-xs font-bold uppercase tracking-wider {{ $esMio ? 'text-gray-500' : 'text-[#5865F2]' }}">
                                    {{ $esMio ? 'Tú enviaste a ' . $mensaje->receptor->name : 'Recibido de ' . $mensaje->emisor->name }}
                                </span>
                                <h3 class="text-white font-bold text-lg mt-1">
                                    Sobre: <a href="{{ route('productos.show', $mensaje->producto_id) }}" class="text-gray-300 hover:text-white hover:underline transition-all">{{ $mensaje->producto->titulo }}</a>
                                </h3>
                            </div>
                            <span class="text-xs text-gray-500">{{ $mensaje->created_at->diffForHumans() }}</span>
                        </div>

                        <div class="bg-[#202225] p-4 rounded-xl text-gray-300 border border-gray-800 pl-2">
                            {{ $mensaje->contenido }}
                        </div>
                        
                        @if(!$esMio)
                            <div class="mt-4 flex justify-end pl-2">
                                <a href="{{ route('productos.show', $mensaje->producto_id) }}" class="text-sm bg-transparent border border-gray-600 hover:border-[#5865F2] hover:text-[#5865F2] text-gray-400 px-4 py-2 rounded-lg font-bold transition-all">
                                    Ver producto para responder ↩
                                </a>
                                @if(!$mensaje->leido && $mensaje->receptor_id === Auth::id())
                                    <form method="POST" action="{{ route('mensajes.leido', $mensaje->id) }}" class="inline-block ms-2">
                                        @csrf
                                        <button type="submit" class="text-sm bg-[#2b2b2b] border border-gray-600 hover:border-[#5865F2] text-gray-300 px-4 py-2 rounded-lg font-bold">Marcar como leído</button>
                                    </form>
                                @endif
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-20 bg-[#2f3136] rounded-3xl border border-gray-700 border-dashed">
                        <h3 class="text-xl font-bold text-white mb-2">Bandeja vacía</h3>
                        <p class="text-gray-400">Aún no tienes mensajes. ¡Sube más productos para atraer compradores!</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>