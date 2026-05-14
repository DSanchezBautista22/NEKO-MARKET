<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductoTest extends TestCase
{
    public function test_usuario_autenticado_puede_publicar_producto_con_validaciones()
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('productos.store'), [
            'titulo' => 'Figura de prueba',
            'descripcion' => 'Descripción bonita',
            'precio' => -5, // precio inválido: negativo
            'estado_conservacion' => 'Nuevo',
            'imagen_url' => UploadedFile::fake()->create('toy.png', 100, 'image/png'),
        ]);

        // Si la validación exige min:0.01 debería fallar y redirigir con errores
        $response->assertSessionHasErrors(['precio']);
    }
}
