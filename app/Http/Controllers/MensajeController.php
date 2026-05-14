<?php

namespace App\Http\Controllers;

use App\Models\Mensaje;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MensajeController extends Controller
{
    // Listado de conversaciones (Bandeja de entrada)
    public function index()
    {
        $mensajes = Mensaje::where('emisor_id', Auth::id())
            ->orWhere('receptor_id', Auth::id())
            ->with(['emisor', 'receptor', 'producto'])
            ->latest()
            ->get();

    $unreadCount = Mensaje::where('receptor_id', Auth::id())->where('leido', false)->count();

    return view('mensajes.index', compact('mensajes', 'unreadCount'));
    }

    // Bandeja de enviados
    public function enviados()
    {
        $mensajes = Mensaje::where('emisor_id', Auth::id())
            ->with(['emisor', 'receptor', 'producto'])
            ->latest()
            ->get();

    $unreadCount = Mensaje::where('receptor_id', Auth::id())->where('leido', false)->count();

    return view('mensajes.enviados', compact('mensajes', 'unreadCount'));
    }

    // Guardar un nuevo mensaje (Seguridad: Validamos todo)
    public function store(Request $request)
    {
        $request->validate([
            'receptor_id' => 'required|exists:users,id',
            'producto_id' => 'required|exists:productos,id',
            'contenido' => 'required|string|max:1000',
        ]);

        // Evitar que un usuario se mande mensajes a sí mismo
        if ($request->receptor_id == Auth::id()) {
            return back()->with('error', 'No puedes enviarte mensajes a ti mismo.');
        }

        // Asegurarnos de que el receptor realmente sea el vendedor del producto
        $producto = Producto::findOrFail($request->producto_id);
        if ($producto->user_id != $request->receptor_id) {
            return back()->withErrors(['receptor_id' => 'El receptor debe ser el vendedor del producto especificado.']);
        }

        // Sanear el contenido para evitar inyección de HTML/JS
        $contenido = strip_tags($request->contenido);

        Mensaje::create([
            'emisor_id' => Auth::id(),
            'receptor_id' => $request->receptor_id,
            'producto_id' => $request->producto_id,
            'contenido' => $contenido,
        ]);

        return back()->with('success', '¡Mensaje enviado con éxito! El vendedor te responderá pronto.');
    }

    // Marcar un mensaje como leído (solo el receptor puede marcarlo)
    public function marcarLeido($id)
    {
        $mensaje = Mensaje::findOrFail($id);
        if ($mensaje->receptor_id != Auth::id()) {
            abort(403);
        }

        $mensaje->leido = true;
        $mensaje->save();

        return back()->with('success', 'Mensaje marcado como leído.');
    }
}