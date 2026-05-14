<x-app-layout>
    <div class="py-12 bg-[#36393f] min-h-screen flex justify-center">
        <div class="w-full max-w-2xl bg-[#2f3136] shadow-2xl sm:rounded-2xl border border-gray-700/50 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-700 flex justify-between items-center bg-[#202225]/50">
                <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-white text-xl">✕</a>
                <h2 class="text-lg font-bold text-gray-100">Subir nuevo producto</h2>
                <div class="w-5"></div> 
            </div>

            <div class="p-6 sm:p-8">
                @if ($errors->any())
                    <div class="mb-6 bg-red-500/10 border border-red-500 text-red-400 p-4 rounded-xl">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf 
                    <div class="mb-8">
                        <div class="flex gap-4 overflow-x-auto pb-4">
                            <label class="shrink-0 w-24 h-24 flex flex-col items-center justify-center border-2 border-dashed border-gray-500 rounded-2xl cursor-pointer hover:border-[#5865F2] hover:bg-[#202225] transition-all group relative overflow-hidden">
                                <span class="text-3xl text-gray-500 group-hover:text-[#5865F2] mb-1 z-10" id="icono_camara">📷</span>
                                <input type="file" name="imagen_url" id="imagen_input" class="hidden" accept="image/*">
                                <div id="vista_previa" class="absolute inset-0 bg-cover bg-center hidden z-20"></div>
                            </label>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <x-input-label for="titulo" value="Título" class="text-gray-400 uppercase text-xs font-semibold" :required="true" />
                            <input type="text" name="titulo" required class="w-full bg-[#202225] border-gray-600 rounded-lg text-gray-100 mt-1" placeholder="Ej: Figura Rem Re:Zero">
                        </div>
                        <div>
                            <x-input-label for="descripcion" value="Descripción" class="text-gray-400 uppercase text-xs font-semibold" :required="true" />
                            <textarea name="descripcion" rows="3" required class="w-full bg-[#202225] border-gray-600 rounded-lg text-gray-100 mt-1" placeholder="Detalles del producto..."></textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="precio" value="Precio (€)" class="text-gray-400 uppercase text-xs font-semibold" :required="true" />
                                <input type="number" step="0.01" name="precio" required class="w-full bg-[#202225] border-gray-600 rounded-lg text-gray-100 mt-1">
                            </div>
                            <div>
                                <label class="text-xs font-semibold text-gray-400 uppercase">Estado</label>
                                <select name="estado_conservacion" class="w-full bg-[#202225] border-gray-600 rounded-lg text-gray-100 mt-1">
                                    <option value="Precintado">Precintado</option>
                                    <option value="Como nuevo">Como nuevo</option>
                                    <option value="Usado">Usado</option>
                                </select>
                            </div>
                            <div>
                                <x-input-label for="categoria" value="Categoría" class="text-gray-400 uppercase text-xs font-semibold" :required="true" />
                                <select name="categoria" required class="w-full bg-[#202225] border-gray-600 rounded-lg text-gray-100 mt-1">
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
                        </div>
                    </div>

                    <button type="submit" class="w-full mt-8 bg-[#5865F2] hover:bg-[#4752C4] text-white font-bold py-4 rounded-full transition-all shadow-lg">
                        Publicar Producto
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('imagen_input').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const vistaPrevia = document.getElementById('vista_previa');
                    vistaPrevia.style.backgroundImage = `url('${e.target.result}')`;
                    vistaPrevia.classList.remove('hidden');
                    document.getElementById('icono_camara').style.opacity = '0';
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</x-app-layout>