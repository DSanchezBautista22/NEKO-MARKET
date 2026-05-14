<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">Editar producto</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-[#202225]/95 text-white rounded-lg">
        <form method="POST" action="{{ route('productos.update', $producto->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div>
            <x-input-label for="titulo" value="Título" class="text-white" :required="true" />
            <x-text-input id="titulo" name="titulo" type="text" class="mt-1 block w-full text-black bg-white" value="{{ old('titulo', $producto->titulo) }}" />
                    </div>

                    <div class="mt-4">
            <x-input-label for="descripcion" value="Descripción" class="text-white" :required="true" />
            <textarea id="descripcion" name="descripcion" class="block w-full mt-1 rounded-md bg-white text-black p-2">{{ old('descripcion', $producto->descripcion) }}</textarea>
                    </div>

                    <div class="mt-4">
            <x-input-label for="precio" value="Precio (USD)" class="text-white" :required="true" />
            <x-text-input id="precio" name="precio" type="number" step="0.01" class="mt-1 block w-full text-black bg-white" value="{{ old('precio', $producto->precio) }}" />
                    </div>

                    <div class="mt-4">
            <x-input-label for="categoria" value="Categoría" class="text-white" :required="true" />
            <select id="categoria" name="categoria" class="block w-full mt-1 rounded-md bg-white text-black p-2">
                @php $cats = ['Cómics','Manga','Figuras','Videojuegos','Consolas','Juegos de mesa','Cartas coleccionables','Merchandising','Libros/artbooks','Pósters','Ropa friki','Funkos','Peluches','DVDs / Blu-ray','Bandas sonoras / vinilos','Miniaturas','Cosplay','Retro gaming']; @endphp
                @foreach($cats as $c)
                    <option value="{{ $c }}" {{ old('categoria', $producto->categoria) === $c ? 'selected' : '' }}>{{ $c }}</option>
                @endforeach
            </select>
                    </div>

                    <div class="mt-4 flex items-center gap-4">
                        <x-primary-button>Guardar</x-primary-button>
                        <a href="{{ route('profile.edit') }}" class="text-gray-300">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
