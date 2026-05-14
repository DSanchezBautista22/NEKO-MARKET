<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductoController extends Controller
{
    // Carga el catálogo optimizado
    public function dashboard()
    {
        // Usamos with ('user') para cargar a los vendedores de golpe
        // y evitar hacer 100 consultas SQL si hay 100 productos.
        $query = Producto::with('user')->latest();

        // Aplicar filtros si vienen por query string
        if (request()->filled('q')) {
            $q = request()->get('q');
            $query->where(function($qbuilder) use ($q) {
                $qbuilder->where('titulo', 'like', "%{$q}%")
                    ->orWhere('descripcion', 'like', "%{$q}%");
            });
        }
        if (request()->filled('categoria')) {
            $query->where('categoria', request()->get('categoria'));
        }

        $productos = $query->get();
        return view('dashboard', compact('productos'));
    }

    // Muestra el detalle del producto
    public function show($id)
    {
        // Busca el producto o saca un error 404 limpio si alguien pone una URL falsa
        $producto = Producto::with('user')->findOrFail($id);
        return view('productos.show', compact('producto'));
    }

    // Listado de productos del usuario (para el perfil)
    public function misProductos()
    {
        $productos = Producto::where('user_id', Auth::id())->latest()->get();
        return view('profile.mis_productos', compact('productos'));
    }

    // Guarda un producto nuevo
    public function store(Request $request)
    {
        // Validación estricta: sólo archivos tipo imagen permitidos
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string|max:2000',
            // Evitamos precios negativos (permitimos 0 para objetos gratuitos)
            'precio' => 'required|numeric|min:0',
            'estado_conservacion' => 'required|string|max:100',
            'categoria' => 'required|string|max:100',
            'imagen_url' => 'nullable|file|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $nombreImagen = null;
        if ($request->hasFile('imagen_url')) {
            $file = $request->file('imagen_url');

            // Verificar MIME real usando getimagesize (más seguro que confiar solo en extensión)
            $imageData = @getimagesize($file->getPathname());
            if ($imageData === false) {
                return back()->withErrors(['imagen_url' => 'El archivo subido no es una imagen válida.']);
            }

            // Generar nombre seguro y único
            $extension = strtolower($file->getClientOriginalExtension());
            $allowedExt = ['jpeg','jpg','png','gif','webp'];
            if (! in_array($extension, $allowedExt, true)) {
                return back()->withErrors(['imagen_url' => 'Extensión no permitida.']);
            }

            $safeName = Str::uuid()->toString() . '.' . $extension;

            // Guardar en disco público con nombre seguro
            $path = $file->storeAs('productos', $safeName, 'public');
            $nombreImagen = $path;
        }

        // Sanea inputs para prevenir inyección de código/HTML
        $titulo = strip_tags($validated['titulo']);
        $descripcion = strip_tags($validated['descripcion']);

        Producto::create([
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'categoria' => strip_tags($validated['categoria']),
            'precio' => $validated['precio'],
            'estado_conservacion' => strip_tags($validated['estado_conservacion']),
            'tiene_caja_original' => $request->has('tiene_caja_original'),
            'imagen_url' => $nombreImagen,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('dashboard')->with('success', '¡Tesoro publicado con éxito!');
    }

    // Mostrar formulario de edición
    public function edit($id)
    {
        $producto = Producto::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('productos.edit', compact('producto'));
    }

    // Actualizar producto
    public function update(Request $request, $id)
    {
        $producto = Producto::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string|max:2000',
            'precio' => 'required|numeric|min:0',
            'categoria' => 'required|string|max:100',
        ]);

        $producto->update([
            'titulo' => strip_tags($validated['titulo']),
            'descripcion' => strip_tags($validated['descripcion']),
            'precio' => $validated['precio'],
            'categoria' => strip_tags($validated['categoria']),
        ]);

        return redirect()->route('profile.edit')->with('success', 'Producto actualizado.');
    }

    // Eliminar producto
    public function destroy($id)
    {
        $producto = Producto::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $producto->delete();
        return back()->with('success', 'Producto eliminado.');
    }
}