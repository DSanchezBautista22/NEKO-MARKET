<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Producto;
use App\Models\Mensaje;
use Tests\TestCase;

class MensajeDeliveryTest extends TestCase
{
    public function test_mensaje_enviado_llega_al_vendedor()
    {
        $comprador = User::factory()->create();
        $vendedor = User::factory()->create();

        $producto = Producto::factory()->create(['user_id' => $vendedor->id]);

        // Comprador envía mensaje
        $this->actingAs($comprador)->post(route('mensajes.store'), [
            'receptor_id' => $vendedor->id,
            'producto_id' => $producto->id,
            'contenido' => '¿Está disponible?'
        ])->assertSessionHas('success');

        // Vendedor revisa bandeja
        $response = $this->actingAs($vendedor)->get(route('mensajes.index'));
        $response->assertStatus(200);
        $response->assertSee('¿Está disponible?');
    }
}
