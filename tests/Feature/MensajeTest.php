<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Producto;
use Tests\TestCase;

class MensajeTest extends TestCase
{
    public function test_no_se_puede_enviar_mensaje_a_si_mismo_y_valida_campos()
    {
        $user = User::factory()->create();
        $producto = Producto::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->post(route('mensajes.store'), [
            'receptor_id' => $user->id, // mismo usuario
            'producto_id' => $producto->id,
            'contenido' => 'Hola',
        ]);

        // Esperamos que la lógica devuelva back con error (mensaje a si mismo)
        $response->assertSessionHas('error');
    }
}
