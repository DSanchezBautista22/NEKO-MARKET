<section>
    <header>
        <h2 class="text-lg font-medium">Mis Productos</h2>
        <p class="mt-1 text-sm text-gray-400">Aquí puedes ver, editar o eliminar los productos que has publicado.</p>
    </header>

    <div class="mt-4">
        @if($productos->isEmpty())
            <p class="text-gray-400">No tienes productos publicados.</p>
        @else
            <div class="space-y-4">
                @foreach($productos as $producto)
                    <div class="p-4 bg-[#121212] rounded-lg flex justify-between items-center">
                        <div class="flex items-center gap-4">
                            @if($producto->imagen_url)
                                <img src="{{ asset('storage/' . $producto->imagen_url) }}" alt="{{ $producto->titulo }}" class="w-20 h-20 object-cover rounded" />
                            @else
                                <div class="w-20 h-20 bg-gray-800 rounded flex items-center justify-center text-sm text-gray-400">SIN IMAGEN</div>
                            @endif

                            <div>
                                <div class="font-bold text-white">{{ $producto->titulo }}</div>
                                <div class="text-sm text-gray-400">{{ \Illuminate\Support\Str::limit($producto->descripcion, 80) }}</div>
                                <div class="text-xs text-gray-500">Precio: ${{ number_format($producto->precio, 2, ',', '.') }}</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('productos.edit', $producto->id) }}" class="px-3 py-2 bg-[#5865F2] text-white rounded">Editar</a>
                            <form method="POST" action="{{ route('productos.destroy', $producto->id) }}" onsubmit="return confirm('¿Eliminar este producto?');">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-2 bg-red-600 text-white rounded">Eliminar</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
