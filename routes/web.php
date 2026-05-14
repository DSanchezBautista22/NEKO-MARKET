<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MensajeController;

/*
|--------------------------------------------------------------------------
| EL MURO DE ENTRADA
|--------------------------------------------------------------------------
| El middleware 'guest' obliga a que SOLO los visitantes vean la portada.
| Si un usuario logueado intenta entrar a '/', Laravel lo patea de vuelta
| al dashboard automáticamente.
*/
Route::get('/', function () {
    return view('welcome');
})->middleware('guest')->name('welcome');


/*
|--------------------------------------------------------------------------
| LA ZONA PRIVADA (Neko Market Real)
|--------------------------------------------------------------------------
| Todo esto requiere haber iniciado sesión (middleware 'auth').
*/
Route::middleware(['auth', 'verified'])->group(function () {
    
    // 1. El Catálogo (Página Principal del usuario)
    Route::get('/dashboard', [ProductoController::class, 'dashboard'])->name('dashboard');
    
    // 2. Formulario para vender
    Route::get('/vender', function () {
        return view('vender');
    })->name('vender');

    // Búsqueda de productos (usa dashboard con filtros)
    Route::get('/productos/search', [ProductoController::class, 'dashboard'])->name('productos.search');

    // 3. Guardar el producto en la BD
    Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');

    // 4. Ver el detalle de UN producto (Vital para la compra)
    Route::get('/producto/{id}', [ProductoController::class, 'show'])->name('productos.show');

    // Gestión de perfil de Laravel Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');
    Route::delete('/profile/avatar', [ProfileController::class, 'deleteAvatar'])->name('profile.avatar.delete');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Mis productos (lista, editar, eliminar)
    Route::get('/mis-productos', [ProductoController::class, 'misProductos'])->name('productos.mine');
    Route::get('/productos/{id}/edit', [ProductoController::class, 'edit'])->name('productos.edit');
    Route::put('/productos/{id}', [ProductoController::class, 'update'])->name('productos.update');
    Route::delete('/productos/{id}', [ProductoController::class, 'destroy'])->name('productos.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/mensajes', [MensajeController::class, 'index'])->name('mensajes.index');
    Route::get('/mensajes/enviados', [MensajeController::class, 'enviados'])->name('mensajes.enviados');
    Route::post('/mensajes', [MensajeController::class, 'store'])->name('mensajes.store');
    Route::post('/mensajes/{id}/leido', [MensajeController::class, 'marcarLeido'])->name('mensajes.leido');
});

require __DIR__.'/auth.php';