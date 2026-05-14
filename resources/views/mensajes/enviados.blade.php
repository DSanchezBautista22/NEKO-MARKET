<x-app-layout>
    <div class="py-12 bg-[#36393f] min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex justify-between items-center mb-8 border-b border-gray-700 pb-4">
                <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tighter uppercase italic">
                    Mensajes <span class="text-[#5865F2]">Enviados</span>
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
                    <div class="bg-[#2f3136] rounded-2xl p-6 shadow-xl border border-gray-700 hover:border-[#5865F2] transition-colors relative overflow-hidden">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <span class="text-xs font-bold uppercase tracking-wider text-gray-500">Enviado a {{ $mensaje->receptor->name }}</span>
                                <h3 class="text-white font-bold text-lg mt-1">Sobre: <a href="{{ route('productos.show', $mensaje->producto_id) }}" class="text-gray-300 hover:text-white hover:underline transition-all">{{ $mensaje->producto->titulo }}</a></h3>
                            </div>
                            <span class="text-xs text-gray-500">{{ $mensaje->created_at->diffForHumans() }}</span>
                        </div>

                        <div class="bg-[#202225] p-4 rounded-xl text-gray-300 border border-gray-800 pl-2">
                            {{ $mensaje->contenido }}
                        </div>

                    </div>
                @empty
                    <div class="text-center py-20 bg-[#2f3136] rounded-3xl border border-gray-700 border-dashed">
                        <h3 class="text-xl font-bold text-white mb-2">No hay mensajes enviados</h3>
                        <p class="text-gray-400">Aún no has enviado mensajes.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
